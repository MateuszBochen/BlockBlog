<?php

namespace System\AppLauncher\Admin\Loaders;

use System\Http\Response\Response;

class RoutingDataSeparator
{
    const MAIN_MENU = 'MAIN_MENU';
    const APP_MAIN_MENU = 'APP_MAIN_MENU';

    private $appDirs = ['MainApp', 'vendor/blockblog/Apps'];
    private $routeArray = [];
    private $menuArray = [];

    public function __construct()
    {
        $this->scan();
    }

    public function getRoutingData()
    {
        return $this->routeArray;
    }

    public function getMenuData()
    {
        return $this->menuArray;
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

                $array = $this->getRouteFromApp($directory.'/'.$app, $app);

                if ($array != false) {
                    $this->mergeRouting($array);                    
                }
            }
        }
    }

    private function getRouteFromApp($appDir, $appName)
    {
        if (!is_dir($appDir)) {
            return false;
        }

        if (file_exists($appDir.'/route.php')) {
            return include($appDir.'/route.php');
        }
        elseif (file_exists($appDir.'/src/'.$appName.'/route.php')) {
            return include($appDir.'/src/'.$appName.'/route.php');
        }

        return false;
    }

    private function mergeRouting($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $item) {
                $this->routeArray[$item['url']] = $item['class'];
                if (isset($item['showIn'])) {
                    $this->collectMenu($key, $item);
                }
            }
        }
        else {
            // TODO exception
        }
    }


    private function collectMenu($key, $item)
    {
        $this->menuArray[$key] = $item;

        /*if ($item['showIn'] == self::MAIN_MENU) {
            $this->menuArray[self::MAIN_MENU][$key] = $item;
        }
        elseif ($item['showIn'] == self::APP_MAIN_MENU) {
            $this->menuArray[self::APP_MAIN_MENU][$key] = $item;
        }*/
    }
}
