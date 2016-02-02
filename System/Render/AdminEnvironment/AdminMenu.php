<?php

namespace System\Render\AdminEnvironment;

class AdminMenu
{   
    private $configs;
    private $appsDir = '/vendor/blockblog/Apps';
    private $ignoreFiles = ['.', '..'];
    private $appsList = [];
    private $tabs = '';

    public function __construct($configs)
    {
        $this->configs = $configs;
        //echo ROOT_DIR; // /home/backen/www/html/BlockBlog
        $this->appsDir = ROOT_DIR.$this->appsDir;
        $this->scan();
        //$this->genereteMeneu();
    }

    public function getMenu()
    {
        return $this->appsList;
    }

    private function scan()
    {
        $list = scandir($this->appsDir);
        $list = array_diff($list, $this->ignoreFiles);
        $apps = [];

        foreach ($list as $app) {
            if (file_exists($this->appsDir.'/'.$app.'/src/AdminMenu.php')) {
                $this->appsList[] = include($this->appsDir.'/'.$app.'/src/AdminMenu.php');
            }
        }
    }
}
