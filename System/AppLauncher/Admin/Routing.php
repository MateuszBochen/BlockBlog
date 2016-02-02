<?php

namespace System\AppLauncher\Admin;

class Routing
{
    
    private $baseUrl = '';
    private $urlParams = [];
    private $argumentsList = [];
    private $argumentsListToRender = [];
    /**
     * array of routing ['url' => 'className']
     */
    private $routeArray = [
        '' => 'MainApp\\HomeApp\\Home',
        'login' => 'MainApp\\Authorization\\Login',
        'logout' => 'MainApp\\Authorization\\Logout',
        'authenticate' => 'MainApp\\Authorization\\Authenticate'
    ];

    public function __construct($params, $routingData)
    {
        $this->routeArray = array_merge($this->routeArray, $routingData);
        $this->urlParams = $params; 
    }

    public function getAppName($url)
    {
        $className = '';

        foreach ($this->routeArray as $index => $class) {

            $index = str_replace('/', '\/', $index);
            $index = $this->prepareIndex($index);

            if (preg_match("/^{$index}$/i", $url)) {
                $className = $class;
                break;
            }
        }

        if (!$className) {
            return false;
        }

       return $className;
    }

    public function getIniValues()
    {
        return $this->argumentsList;
    } 

    private function prepareIndex($index)
    {
        $matches = [];
        $array = explode('\/{', $index);
        $this->baseUrl = $array[0];
        unset($array[0]);

        return $this->baseUrl.$this->insertRegex($array, 1);
    }

    private function insertRegex($array, $index) 
    {
        if (!isset($array[$index])) {
            return '';
        }

        $item = str_replace('}', '', $array[$index]);
        $item = str_replace(':d', '\/[0-9]+', $item);
        $item = str_replace(':s', '\/[a-z]+', $item);

        $max = count($array);

        return '(\/'.$item.')*?'.(($index+1) <= $max ? '|'.$this->insertRegex($array, ($index+1)) : '');
    }
}
