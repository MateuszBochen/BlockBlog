<?php

namespace System\Autoloader;

use System\Autoloader\AutoloaderException;

class Autoloader 
{

    public function register()
    {
        $autoload = array($this, 'load');
        \spl_autoload_register($autoload);
    }

    public function load($class)
    {
        $fileName = ROOT_DIR.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (!file_exists($fileName)){
            throw new AutoloaderException('File <i>'.$fileName.'</i> does not exist');
        }

        require_once $fileName;
    }
}
