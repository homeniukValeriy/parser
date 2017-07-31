<?php

namespace Parser\Commands;

class DefaultCommand extends Command {
	public function execute(\Parser\Base\Request $request)
	{
		print "Invalid Command!" . PHP_EOL;
		print "Use 'help' command to see all commands." . PHP_EOL;
	}
}