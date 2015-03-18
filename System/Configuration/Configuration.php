<?php

namespace System\Configuration;

use System\Configuration\ConfigurationException;

class Configuration extends ConfigurationException
{
    private $configs;
    private $__loaded = [];

    public function __construct()
    {
        $this->configs = include ROOT_DIR.'/Config/config.php';
    }

    public function getParam($paramName)
    {
        if (isset($this->__loaded[$paramName])){
            return $this->__loaded[$paramName];
        }

        $paramAsArray = explode('.', $paramName);
        $paramName = array_shift($paramAsArray);

        if (!isset($this->configs[$paramName])) {
            throw new ConfigurationException('Param <i>'.$paramName.'</i> does not exist');
        }

        if (!is_array($this->configs[$paramName])) {
            return $this->configs[$paramName];
        }

        $lastValue = $this->configs[$paramName];
        $lastValueAsString = $paramName;

        foreach ($paramAsArray as $key) {
            if (!isset($lastValue[$key])) {
                throw new ConfigurationException('Param <i>'.$lastValueAsString.'.'.$key.'</i> does not exist');
            }

            $lastValueAsString .= '.'.$key;
            $lastValue = $lastValue[$key];

            if (!is_array($lastValue)){
                return $lastValue;
            }
        }
        $__loaded[$lastValueAsString] = $lastValue;
        return $lastValue;
    }
}
