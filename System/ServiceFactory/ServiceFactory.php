<?php

namespace System\ServiceFactory;

use System\ServiceFactory\ServiceFactoryException;
use System\Configuration;

class ServiceFactory
{
    private static $instance;
    private static $loadedClasses = [];
    private static $configuration;
    private static $mainServices = [
        'routing' => 
            [
                'class' => 'Services\Routing\Routing',
                'arguments' => [], // @service; $configProperty
                'prototype' => false
            ]
        ];

    public static function getService($serviceName)
    {

        if (!self::$configuration) {
            self::$configuration = new Configuration();
        }

        if (!isset(self::$mainServices[$serviceName])) {
            throw new ServiceFactoryException('Service <i>'.$serviceName.'</i> does not exist');
        }

        $service = self::$mainServices[$serviceName];

        if (!is_array($service)) {
            throw new ServiceFactoryException('Invalid Service');
        }

        if (isset(self::$loadedClasses[$serviceName]) && $service['prototype'] == false) {
            return self::$loadedClasses[$serviceName];
        }

        $argumentsArray = [];

        if (is_array($service['arguments']) && !empty($service['arguments'])) {
            foreach ($service['arguments'] as $argument) {

                $paramName = substr($argument, 1);

                if ($argument[0] == '@') {
                    $argumentsArray[] = self::$getService($paramName);
                }
                elseif($argument[0] == '$') {
                    $argumentsArray[] = self::$configuration->$paramName;
                }
            }
        }

        if (!class_exists($service['class'])) {
            throw new ServiceFactoryException('Class '.$service['class'].' does not exist');
        }

        $reflection = new \ReflectionClass($service['class']); 
        $myClassInstance = $reflection->newInstanceArgs($argumentsArray); 

        self::$loadedClasses[$serviceName] = $myClassInstance;

        return self::$loadedClasses[$serviceName];
    }
}
