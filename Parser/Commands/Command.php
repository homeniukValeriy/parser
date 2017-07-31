<?php

namespace Parser\Commands;

abstract class Command {
	abstract function execute(\Parser\Base\Request $request);
}