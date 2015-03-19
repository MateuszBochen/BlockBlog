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

        $url = $serviceFactory->getService('url');

        if ($url->getUrlParam(0) == $configuration->getParam('adminDir')) {
            $appLauncher = new AppLauncher\AdminAppLauncher($url, $configuration);
        }
        else {
            $appLauncher = new AppLauncher\UserAppLauncher($url, $configuration);
        }
    }
}
