<?php

namespace Parser\Commands;

class HelpCommand extends Command {
	public function execute(\Parser\Base\Request $request)
	{
		print "Command 'parse' - recursively parses the page and saves the images to a file. Requires one parameter 'url'" . PHP_EOL . PHP_EOL;

		print "Command 'report' - parses one page and outputs images to the console. Requires one parameter 'domain'" . PHP_EOL . PHP_EOL;

		print "Command 'help' - displays a list of commands" . PHP_EOL . PHP_EOL;
	}
}