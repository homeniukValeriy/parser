<?php

namespace Parser\Commands;

class ReportCommand extends Command {
	public function execute(\Parser\Base\Request $request)
	{
		$url = $request->getProperty(1);

		if (!$url) {
			throw new \Exception('Missing URL!');
		}

		$parser = new \Parser\Domain\ParserCore($url);
		$data = $parser->parse();

		if (!$data) {
			print "There are no images." . PHP_EOL;
		} else {
			$link_data = array_shift($data);

			print "Images: " . PHP_EOL . PHP_EOL;

			foreach ($link_data['images'] as $img) {
				print $img . PHP_EOL;
			}
		}
		
	}
}