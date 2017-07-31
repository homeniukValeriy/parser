<?php

namespace Parser\Base;

class Request{
	private $properties = array();

	public function __construct()
	{
		array_shift($_SERVER['argv']);
		foreach ($_SERVER['argv'] as $arg) {
			$this->properties[] = $arg;
		}
	}

	public function getProperty($key)
	{
		return isset($this->properties[$key]) ? $this->properties[$key] : null;
	}

	public function setProperty($key, $value)
	{
		$this->properties[$key] = $value;
	}
}