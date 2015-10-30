<?php

namespace System\AppLauncher\Admin;

class Routing
{

    /**
     * array of routing ['url' => 'className']
     */
    private $routeArray = [
        '' => 'MainApp\\HomeApp\\Home',
        'login' => 'MainApp\\Authorization\\Login',
        'logout' => 'MainApp\\Authorization\\Logout',
        'authenticate' => 'MainApp\\Authorization\\Authenticate',
        'pages/create' => 'MainApp\\Pages\\Create',
    ];

    public function __construct()
    {

    }

    public function getApp($url, $serviceFactory, $configuration)
    {
        $className = '';

        foreach ($this->routeArray as $index => $class) {
            $index = str_replace('/', '\/', $index);

            if (preg_match("/^{$index}$/i", $url)) {
                $className = $class;
                break;
            }
        }

        if (!$className) {
            return '';
            exit;
        }

        $reflection = new \ReflectionClass($className);
        return $reflection->newInstanceArgs([$serviceFactory, $configuration]);
    }
}
