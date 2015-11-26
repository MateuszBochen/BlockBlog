<?php

namespace System\AppLauncher\Admin;

class Routing
{
    private $appDirs = ['MainApp'];
    private $urlParams = [];
    private $argumentsList = [];
    /**
     * array of routing ['url' => 'className']
     */
    private $routeArray = [
        '' => 'MainApp\\HomeApp\\Home',
        'login' => 'MainApp\\Authorization\\Login',
        'logout' => 'MainApp\\Authorization\\Logout',
        'authenticate' => 'MainApp\\Authorization\\Authenticate'
    ];

    public function __construct($params)
    {
        $this->scan();

        $this->urlParams = $params; 
    }

    public function getApp($url, $serviceFactory, $configuration)
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

        $reflection = new \ReflectionClass($className);

        $app = $reflection->newInstanceArgs([$serviceFactory, $configuration]);

        if (!method_exists ($app, 'init')) {
            throw new RoutingException('Method <b>init()</b> does not exist in <b>'.get_class($app).'</b>');
        }

        $method = $reflection->getMethod('init');

        $this->createInitArguments($method->getParameters());

        return $app;
    }

    public function getIniValues()
    {
        return $this->argumentsList;
    }

    private function createInitArguments($params)
    {
        foreach ($params as $param) {

            $value = array_search($param->name, $this->urlParams);

            if($value === false) {
                if($param->isOptional()) {
                    $this->argumentsList[] = $param->getDefaultValue();
                    continue;
                }
                else {
                    throw new RoutingException("Invalid params for this routing");
                }
            }

            if(!isset($this->urlParams[$value+1])){
                throw new RoutingException("Invalid params for this routing");
            }

            $this->argumentsList[] = $this->urlParams[$value+1];
        }
    }

    private function scan()
    {
        foreach($this->appDirs as $dir) {
            $directory = ROOT_DIR.'/'.$dir;
            $apps = scandir($directory);

            foreach ($apps as $app) {
                if ($app == '.' || $app  == '..') {
                    continue;
                }

                $array = $this->getRouteFromApp($directory.'/'.$app);

                if ($array != false) {
                    $this->routeArray = array_merge($this->routeArray, $array);
                }
            }
        }
    }

    private function getRouteFromApp($appDir)
    {
        if (!is_dir($appDir)) {
            return false;
        }

        if (!file_exists($appDir.'/route.php')) {
            return false;
        }

        return include($appDir.'/route.php');
    }

    private function prepareIndex($index)
    {
        $matches = [];
        $array = explode('\/{', $index);
        $baseUrl = $array[0];
        unset($array[0]);

        return $baseUrl.$this->insertRegex($array, 1);
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
