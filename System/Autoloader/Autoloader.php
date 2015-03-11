<?php

namespace System\Autoloader;

class Autoloader
{
	public function register()
    {
		$autoload = array($this, 'load');
		\spl_autoload_register($autoload);
	}

	public function load($class)
    {
		require_once ROOT_DIR.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	}
}
