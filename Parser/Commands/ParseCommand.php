<?php

namespace Parser\Commands;

class ParseCommand extends Command {
	public function execute(\Parser\Base\Request $request)
	{
		$url = $request->getProperty(1);

		if (!$url) {
			throw new \Exception('Missing URL!');
		}

		$parser = new \Parser\Domain\ParserCore($url);
		$data = $parser->parse(true);

		$csv_file = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'results.csv';
		
		$fp = fopen($csv_file, 'w');

		fputcsv($fp, array('Page', 'Image'));

		foreach ($data as $link => $link_data) {
			foreach ($link_data as $images) {
				foreach ($images as $img) {
					fputcsv($fp, array($link, $img));
				}
			}
		}

		fclose($fp);

		print "See results in '{$csv_file}'" . PHP_EOL;
	}
}