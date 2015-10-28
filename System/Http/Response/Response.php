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

}
