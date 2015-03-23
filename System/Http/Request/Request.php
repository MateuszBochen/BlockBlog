<?php

namespace System\Http\Request;

class Request
{
    private $applicatopnPath;
    private $urlParams;
    private $myPost = [];
    private $myGet = [];

    public function __construct()
    {
        $this->applicatopnPath = '/'.implode(explode('/', $_SERVER['PHP_SELF'], -1));
        $this->urlParams = explode('/', trim(str_replace($this->applicatopnPath, '', $_SERVER['REDIRECT_URL']), '/'));

        $this->myPost = $_POST;
        $this->myGet = $_GET;
    }

    public function getUrlParam($index)
    {
        if (isset($this->urlParams[$index])) {
            return $this->urlParams[$index];
        }
        return null;
    }

    public function post($name)
    {
        return $this->getFromArray($name, $this->myPost);
    }

    public function get($name)
    {
        return $this->getFromArray($name, $this->myGet);
    }

    private function getFromArray($index, &$array)
    {
        $paramAsArray = explode('.', $index);
        $lastValue = $array;

        foreach ($paramAsArray as $index) {
            if (!isset($lastValue[$index])) {
                return '';
            }

            if (!is_array($lastValue[$index])) {
                return $lastValue[$index];
            }

            $lastValue = $lastValue[$index];
        }

        return $lastValue;
    }
}
