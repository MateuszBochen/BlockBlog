<?php
namespace System;

class Configuration
{
    public $mainServices = [
        'routing' => 
            [
                'class' => 'Services\Routing\Routing',
                'arguments' => [],
                'prototype' => false,
                'factoryClass' => ''
            ]
        ];
}
