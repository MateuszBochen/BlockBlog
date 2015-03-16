<?php

namespace System;

use System\Configuration\Configuration;
use System\ServiceFactory\ServiceFactory;

class Kernel
{
    private $configuration;
    
    public function init()
    {
        $classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();

        $this->configuration = new Configuration();
        
        $serviceFactory = new ServiceFactory($this->configuration);
        
        $routing = $serviceFactory->getService('routing');

    }
}
