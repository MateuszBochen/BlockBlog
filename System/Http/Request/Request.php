<?php

namespace System\Http\Request;

class Request
{
    private $applicatopnPath;
    private $urlParams;
    private $myPost = [];
    private $myGet = [];
    private $currentUrl;

    public function __construct()
    {
        $this->applicatopnPath = implode('/', explode('/', $_SERVER['PHP_SELF'], -1));

        $string = str_replace($this->applicatopnPath, '', (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : ''));

        $this->currentUrl = trim($string, '/');
        $this->urlParams = explode('/', $this->currentUrl);

        $this->myPost = $_POST;
        $this->myGet = $_GET;
    }

    public function getCurrentUrl()
    {
        return $this->currentUrl;
    }

    public function getUrlParam($index)
    {
        if (isset($this->urlParams[$index])) {
            return $this->urlParams[$index];
        }
        return null;
    }

    public function getUrlParams()
    {
        return $this->urlParams;
    }

    public function post($name)
    {
        return $this->getFromArray($name, $this->myPost);
    }

    public function get($name)
    {
        return $this->getFromArray($name, $this->myGet);
    }

    public function getServerValue($name)
    {
        if (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        }

        return null;
    }

    public function getApplicatopnPath()
    {
        return $this->applicatopnPath;
    }

    private function getFromArray($index, &$array)
    {
        $paramAsArray = explode('.', $index);
        $lastValue = $array;

        foreach ($paramAsArray as $index) {
            if (!isset($lastValue[$index])) {
                return '';
            }

            $lastValue = $lastValue[$index];
        }

        return $lastValue;
    }
}
