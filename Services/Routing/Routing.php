<?php

namespace Services\Routing;

class Routing
{
    private $applicatopnPath;
    private $urlParams;
    
    public function __construct()
    {
        $this->applicatopnPath = '/'.implode(explode('/', $_SERVER['PHP_SELF'], -1));
        $this->urlParams = explode('/', trim(str_replace($this->applicatopnPath, '', $_SERVER['REDIRECT_URL']), '/'));
        /* echo '<pre>';
        var_dump($this->applicatopnPath);
        print_r($_SERVER);
        print_r($this->urlParams); */
    }
    
    public function getUrlParam($index)
    {
        if (isset($this->urlParams[$index])) {
            return $this->urlParams[$index];
        }
        return null;
    }
}
