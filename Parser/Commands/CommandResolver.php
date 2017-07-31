<?php

namespace Parser\Commands;

class CommandResolver {
	private $default_cmd = null;

	public function __construct()
	{
		$this->default_cmd = new DefaultCommand();
	}

	public function getCommand($request)
	{
		$cmd = $request->getProperty(0);

		if (!$cmd) {
			return $this->default_cmd;
		}

		$sep = DIRECTORY_SEPARATOR;

		$file = 'Parser' . $sep . 'Commands' . $sep . ucfirst($cmd) . 'Command.php';
		$class_name = '\\Parser\\Commands\\' . ucfirst($cmd) . 'Command';
		
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $file)) {
			return new $class_name();
		}

		return $this->default_cmd;
	}
}