<?php

namespace System\Configuration;

use System\Configuration\ConfigurationException;

class Configuration extends ConfigurationException
{

    public function __construct()
    {
    
    }

    public function getParam($paramName)
    {
        $paramAsArray = explode('.', $paramName);
        $paramName = $fruit = array_shift($paramAsArray);

        if (!isset($this->$paramName)) {
            throw new ConfigurationException('Param <i>'.$paramName.'</i> does not exist');
        }

        if (!is_array($this->$paramName)) {
            return $this->$paramName;
        }

        $lastValue = $this->$paramName;
        $lastValueAsString = $paramName;

        foreach ($paramAsArray as $key) {
            if (!isset($lastValue[$key])) {
                throw new ConfigurationException('Param <i>'.$lastValueAsString.'</i> does not exist');
            }

            $lastValueAsString .= '.'.$key;
            $lastValue = $lastValue[$key];

            if (!is_array($lastValue)){
                return $lastValue;
            }
        }

        return $lastValue;
    }
}
