<?php

namespace System\ServiceFactory;

use System\ServiceFactory\ServiceFactoryException;

class ServiceFactory
{
    private $loadedClasses = [];
    private $configuration;
    private $mainServices = [
        'request' => 
            [
                'class' => 'System\Http\Request\Request',
                'arguments' => [], // @service; $configProperty
                'prototype' => false
            ],
        'db' => 
            [
                'class' => 'Simplon\Mysql\Mysql',
                'arguments' => ['$mysql.host', '$mysql.user', '$mysql.password', '$mysql.databaseName'], // @service; $configProperty
                'prototype' => false
            ],
        'crud' => 
            [
                'class' => 'Simplon\Mysql\Crud\SqlCrudManager',
                'arguments' => ['@db'], // @service; $configProperty
                'prototype' => false
            ],
        'authentication' => 
            [
                'class' => 'System\Authentication\Authentication',
                'arguments' => ['@db'], // @service; $configProperty
                'prototype' => false
            ]
        ];

    public function __construct($configuration)
    {
        $this->configuration = $configuration;

        // load services from list TODO
    }

    public function getService($serviceName)
    {
        if (!isset($this->mainServices[$serviceName])) {
            throw new ServiceFactoryException('Service <i>'.$serviceName.'</i> does not exist');
        }

        $service = $this->mainServices[$serviceName];

        if (!is_array($service)) {
            throw new ServiceFactoryException('Invalid Service');
        }

        if (isset($this->loadedClasses[$serviceName]) && $service['prototype'] == false) {
            return $this->loadedClasses[$serviceName];
        }

        $argumentsArray = [];

        if (is_array($service['arguments']) && !empty($service['arguments'])) {
            foreach ($service['arguments'] as $argument) {

                $paramName = substr($argument, 1);

                if ($argument[0] == '@') {
                    $argumentsArray[] = $this->getService($paramName);
                }
                elseif($argument[0] == '$') {
                    $argumentsArray[] = $this->configuration->getParam($paramName);
                }
            }
        }

        if (!class_exists($service['class'])) {
            throw new ServiceFactoryException('Class '.$service['class'].' does not exist');
        }

        $reflection = new \ReflectionClass($service['class']); 
        $myClassInstance = $reflection->newInstanceArgs($argumentsArray); 

        $this->loadedClasses[$serviceName] = $myClassInstance;

        return $this->loadedClasses[$serviceName];
    }
}
