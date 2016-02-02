<?php

namespace System\AppLauncher\Admin;

use System\AppLauncher\Admin\Loaders\RoutingDataSeparator;

class MenuBuilder
{
    const MAIN_MENU = 'MAIN_MENU';
    const APP_MAIN_MENU = 'APP_MAIN_MENU';

    private $mainMenu = [];
    private $appMenu = [];
    private $rawMenuData = [];
    private $request;
    private $translator;
    private $admindir;

    public function __construct($menuData, $request, $translator, $admindir)
    {
        $this->request = $request;
        $this->translator = $translator;
        $this->admindir = $admindir;

        $this->rawMenuData = $menuData;
        $this->sortMenu();
    }

    public function url($url)
    {   
        $url = $this->prepareUrl($url);
        return $this->request->getApplicatopnPath().'/'.$this->admindir.'/'.trim($url, '/');
    }

    public function buildMainMenu($array = [])
    {
        $array = (empty($array) ? $this->mainMenu : $array);
        $htmlMenu = '';
        foreach ($array as $item) {
            $liElement = '';

            $icon = '<i class="fa fa-fw '.(!isset($item['icon']) ?: $item['icon']).'"></i>';
            $url = $this->url($item['url']);

            $isActive = ($this->isActive($item['url']) ? 'active' : '');
            $name = $this->translator->t($item['name']);


            if (!empty($item['child'])) {
                $liElement = '<li class="has-dropdown '.$isActive.'"><a href="'.$url.'" >'.$icon.' '.$name.'</a>';
                $liElement .= '<ul class="sub-menu">';
                $liElement .= $this->buildMainMenu($item['child']);
                $liElement .= '</ul>';
                $liElement .= '</li>';
            }
            else {
                $liElement = '<li class="'.$isActive.'"><a href="'.$url.'" >'.$icon.' '.$name.'</a></li>';
            }

            $htmlMenu .= $liElement;
        }

        return $htmlMenu;
    }

    private function isActive($url)
    {
        $url = $this->prepareUrl($url);
        $url = $this->admindir.'/'.$url;

        $currentUrl = $this->request->getCurrentUrl();
        $currentUrl = str_replace('/', '\/', $currentUrl);

        if (preg_match("/^$currentUrl(.*?)/", $url)) {
            return true;
        }

        return false;
    }

    private function sortMenu()
    {
        foreach ($this->rawMenuData as $key => $value) {
            if (!isset($value['parent'])) {
                $chldsArray = [];
                $this->findChildrenFor($key, $chldsArray);
                $this->addToCollect($key, $value, $chldsArray);
            }
        }
    }

    private function findChildrenFor($parentName, &$chldsArray)
    {
        foreach ($this->rawMenuData as $key => $value) {
            if (isset($value['parent']) && $value['parent'] == $parentName) {
                $chldsArray[$key] = $value;
                $newChildArray = [];
                unset($this->rawMenuData[$key]);
                $this->findChildrenFor($key, $newChildArray);
                $chldsArray[$key]['child'] = $newChildArray;
            }
        }
    }

    private function addToCollect($key, $item, $child)
    {
        $item['child'] = $child;

        if ($item['showIn'] == self::MAIN_MENU) {
            $this->mainMenu[] = $item;
        }
        elseif ($item['showIn'] == self::APP_MAIN_MENU) {
            $this->appMenu[$key] = $item;
        }
    }

    private function prepareUrl($url)
    {
        $r = explode('{', $url);
        return trim($r[0], '/');
    }
}
