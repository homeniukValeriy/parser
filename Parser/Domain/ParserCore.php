<?php

namespace Parser\Domain;

class ParserCore {

	private $url;

	private $protocol;
	private $base_url;

	public function __construct($url)
	{
		$this->setURL($url);
	}

	public function setURL($url)
	{
		if (!preg_match('/http[s]?\:\/\/.+/i', $url)) {
			$url = 'http://' . $url;
		}

		$url_parts = parse_url($url);

		if ($url_parts === false) {
			throw new \Exception("Error! Invalid URL.");
		}

		$this->protocol = $url_parts['scheme'];
		$this->base_url = $this->protocol . '://' . $url_parts['host'];

		if (isset($url_parts['port']) && $url_parts['port']) {
			$this->base_url .= ':' . $url_parts['port'];
		}

		$this->url = $url;
	}

	private function loadPage($url)
	{
		return file_get_contents($url);
	}

	private function checkLink($url)
	{
		if ($url[0] == '/' && $url[1] != '/') {
			$url = $this->base_url . $url;
		}
		if ($url[0] == '/' && $url[1] == '/') {
			$url = 'http:' . $url;
		}
		return $url;
	}

	private function findLinks($content)
	{
		$links = array();

		if (preg_match_all('/<a.+href=[\'"]([^\'"]+)[\'"][^>]+>/i', $content, $matches)) {
			foreach ($matches[1] as $url) {
				$links[$url] = $this->checkLink($url);
			}
		}

		return $links;
	}

	private function findImages($content)
	{
		$images = array();

		if (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"][^>]+>/i', $content, $matches)) {
			foreach ($matches[1] as $url) {
				$images[$url] = $this->checkLink($url);
			}
		}

		return $images;
	}

	private function parsePage($url)
	{
		$content = $this->loadPage($url);
		$data = array();
		
		$images = $this->findImages($content);
		foreach ($images as $img) {
			$data['images'][$img] = $img;
		}

		$links = $this->findLinks($content);
		foreach ($links as $link) {
			$data['links'][$link] = $link;
		}

		return $data;
	}

	public function parse($recursively = false)
	{
		$data = array();

		if (!$recursively) {

			$tmp_data = $this->parsePage($this->url);
			if ($tmp_data) {
				$data[$this->url]['images'] = $tmp_data['images'];
			}

		} else {

			$links_to_parse = array($this->url => $this->url);
			$parsed_links = array();

			while (count($links_to_parse)) {

				$current_link = array_shift($links_to_parse);
				$parsed_links[$current_link] = $current_link;

				$tmp_data = $this->parsePage($current_link);

				if ($tmp_data) {
					$data[$current_link]['images'] = $tmp_data['images'];

					foreach ($tmp_data['links'] as $link) {
						if (!isset($parsed_links[$link]) && strpos($link, $this->base_url) === 0) {
							$links_to_parse[$link] = $link;
						}
					}
				
				}

			}

		}

		return $data;
	}
}