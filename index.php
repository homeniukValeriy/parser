<?php

spl_autoload_register(function($path){

	if (preg_match('/\\\\/', $path)) {
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
	}
	
	$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . '.php';

	if (file_exists($path)) {
		require_once($path);
	}
});

$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);

try {
	$app = new \Parser\App();
	$app->run();
} catch (\Exception $e) {
	print $e->getMessage();
}