<?php

namespace System\Http\Request;

class Request
{
    private $applicatopnPath;
    private $urlParams;
    private $requestData = [];
    private $currentUrl;

    public function __construct()
    {
        $this->applicatopnPath = implode('/', explode('/', $_SERVER['PHP_SELF'], -1));

        $string = str_replace($this->applicatopnPath, '', (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : ''));

        $this->currentUrl = trim($string, '/');
        $this->urlParams = explode('/', $this->currentUrl);


        $this->prepareRequestData();
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
        return $this->getFromArray($name, $this->requestData);
    }

    public function get($name)
    {
        return $this->getFromArray($name, $this->requestData);
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

    public function isPost()
    {
        return $this->isMethod('POST');
    }

    public function isGet()
    {
        return $this->isMethod('GET');
    }

    public function isPut()
    {
        return $this->isMethod('PUT');
    }

    public function isHead()
    {
        return $this->isMethod('HEAD');
    }

    public function isDelete()
    {
        return $this->isMethod('DELETE');
    }

    public function isOptions()
    {
        return $this->isMethod('OPTIONS');
    }

    private function isMethod($check)
    {
        $method = $this->getServerValue('REQUEST_METHOD');

        if($method == $check) {
            return true;
        }

        return false;
    }

    private function prepareRequestData()
    {
        if ($this->isPost()) {
            $this->requestData = $_POST;
        }
        elseif ($this->isGet()) {
            $this->requestData = $_GET;
        }
        else {
            $inputData = file_get_contents("php://input");
            parse_str($inputData, $this->requestData);
        }
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
