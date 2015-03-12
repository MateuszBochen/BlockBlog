<?php

namespace System;

use System\Configuration;
use System\ServiceFactory\ServiceFactory;

class Kernel
{
    private $configuration;
    
    public function init()
    {
        $classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();

        $this->configuration = new Configuration();

        $routing = ServiceFactory::getService('routing');


    }
}
