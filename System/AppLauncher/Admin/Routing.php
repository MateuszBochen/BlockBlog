<?php

namespace System\AppLauncher\Admin;

class Routing
{

    /**
     * array of routing ['url' => 'className']
     */
    private $routeArray = [
        'login' => 'MainApp\\Authorization\\Login',
        'authenticate' => 'MainApp\\Authorization\\Authenticate',
    ];

    public function __construct()
    {

    }

    public function getApp($url, $serviceFactory, $configuration)
    {
        $className = '';

        foreach ($this->routeArray as $index => $class) {
            if (preg_match("/^{$index}/i", $url)) {
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
