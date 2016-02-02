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
        'form' => 
            [
                'class' => 'System\Http\Form\Form',
                'arguments' => ['@request'],
                'prototype' => false
            ],
        'response' => 
            [
                'class' => 'System\Http\Response\Response',
                'arguments' => [],
                'prototype' => false
            ],
        'db' => 
            [
                'class' => 'BlockBlog\Mysql',
                'arguments' => ['$mysql'],
                'prototype' => false
            ],
        'orm' => 
            [
                'class' => 'BlockBlog\ORM',
                'arguments' => ['@db'],
                'prototype' => false
            ],
        'session' => 
            [
                'class' => 'System\Http\Session\Session',
                'arguments' => [],
                'prototype' => false
            ],
        'notifications' => 
            [
                'class' => 'System\Http\Session\Notifications',
                'arguments' => ['@session'],
                'prototype' => false
            ],
        'authentication' => 
            [
                'class' => 'System\Authentication\Authentication',
                'arguments' => ['@request', '@session', '@user.manager', '@user.active'],
                'prototype' => false
            ],
        'user.manager' => 
            [
                'class' => 'System\User\UserManager',
                'arguments' => ['@orm', '$secret'],
                'prototype' => false
            ],
        'user.active' => 
            [
                'class' => 'System\User\ActiveUser',
                'arguments' => [],
                'prototype' => false
            ],
        'render' => 
            [
                'class' => 'System\Render\Render',
                'arguments' => ['$cacheDir', '$render'],
                'prototype' => false
            ],
        'translator' => 
            [
                'class' => 'System\Languages\Translator',
                'arguments' => [],
                'prototype' => false
            ]/*,
        'render.admin.environment' => 
            [
                'class' => 'System\Render\AdminEnvironment',
                'arguments' => ['@request', '@notifications', '@user.active', '$adminDir'],
                'prototype' => false
            ]*/
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
