<?php
namespace System;

use System\Configuration;

class Kernel
{
	public function init()
    {
		$classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();
        
        $config = new Configuration();
        
        var_dump($config->mainServices);
    }
}
