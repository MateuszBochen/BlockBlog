<?php

namespace System\Http\Response;

class Response
{

    private $applicatopnPath;

    public function __construct()
    {
        $this->applicatopnPath = implode('/', explode('/', $_SERVER['PHP_SELF'], -1));
    }

    public function redirect($url)
    {
        $url = trim($url, '/');
        header("Location: ".$this->applicatopnPath.'/'.$url, true, 301);
        //die();
    }

    public function html($code)
    {
        header('Content-Type: text/html; charset=utf-8');
        echo $code;
    }

    public function jsonArray($array)
    {
        $json = json_encode($array);

        return $this->json($json);
    }

    public function json($json)
    {
        header('Access-Control-Allow-Origin *');
        header('Content-Type: application/json');
        echo $json;

        return $this;
    }
}
