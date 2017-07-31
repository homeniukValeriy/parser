<?php

namespace Parser;

class App {

	private $request;

	public function __construct()
	{
		$this->request = new \Parser\Base\Request();
	}

	public function run()
	{
		$cmd_resolver = new \Parser\Commands\CommandResolver();
		$cmd = $cmd_resolver->getCommand($this->request);
		$cmd->execute($this->request);
	}
}