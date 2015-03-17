<?php

namespace System;

use System\Configuration\Configuration;
use System\ServiceFactory\ServiceFactory;
use System\AppLauncher;

class Kernel
{

    public function init()
    {   
        $appLauncher = null;
        $classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();

        $configuration = new Configuration();

        $serviceFactory = new ServiceFactory($configuration);

        $routing = $serviceFactory->getService('routing');

        if ($routing->getUrlParam(0) == $configuration->getParam('adminDir')) {
            $appLauncher = new AppLauncher\AdminAppLauncher($routing, $configuration);
        }
        else {
            $appLauncher = new AppLauncher\UserAppLauncher($routing, $configuration);
        }

        var_dump($appLauncher);
    }
}
