<?php
namespace System;

use System\Configuration;
use System\ServiceFactory;

class Kernel
{
	public function init()
    {
		$classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();
        
        $config = new Configuration();
        $serviceFactory = new ServiceFactory();
        
        $serviceFactory->addClass('dupa');
        $serviceFactory->addClass('dupa 2');
        
        $serviceFactory2 = new ServiceFactory();
        $serviceFactory2->addClass('dupa 3');
        
        var_dump($serviceFactory2->getLoadedClasses());
    }
}
