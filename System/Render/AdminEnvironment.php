<?php

namespace System\Render;

use Atline\Atline\Environment;

class AdminEnvironment extends Environment
{
    private $request;
    private $notifications;
    private $admindir;
    private $user;
    private $appParams = [];
    private $appMainUrl = '';
    private $menu;

    public $appName;
    public $appSubName;

    public function __construct($request, $notifications, $user, $admindir, $appParams, $appMainUrl, $menu)
    {
        $this->request = $request;
        $this->notifications = $notifications;
        $this->admindir = $admindir;
        $this->user = $user->getUser();
        $this->appParams = $appParams;
        $this->appMainUrl = $appMainUrl;
        $this->menu = $menu;
    }

    public function getMenu()
    {
        return $this->menu->buildMainMenu();
    }

    public function _setAppParams()
    {

    }

    public function setCss($path)
    {
        return '<link rel="stylesheet" href="'.$this->request->getApplicatopnPath().'/Admindir/'.$path.'">';
    }

    public function setJs($path)
    {
        return '<script src="'.$this->request->getApplicatopnPath().'/Admindir/'.$path.'"></script>';
    }

    public function path($path)
    {
        return $this->request->getApplicatopnPath().'/'.$path;
    }

    public function getErrors()
    {
        return $this->notifications->getByType('error');
    }

    public function getSuccesses()
    {
        return $this->notifications->getByType('success');
    }

    public function url($url)
    {
        return $this->menu->url($url);
    }

    public function appUlr($params)
    {
        $params = array_merge($this->appParams, $params);
        $paramUrl = [];

        foreach ($params as $param => $value) {
            $paramUrl[] = $param.'/'.$value;
        }

        return $this->request->getApplicatopnPath().'/'.$this->admindir.'/'.$this->appMainUrl.'/'.implode('/', $paramUrl);
    }

    public function pagination($allPages)
    {
        $html = '<ul class="pagination">';
        for($i = 0; $i < $allPages; $i++) {
            $html .= '<li><a href="'.$this->appUlr(['page' => $i]).'">'.($i+1).'</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function user($prop)
    {
        $function = 'get'.ucfirst($prop);

        return $this->user->$function();
    }

    // TODO
    public function t($word)
    {
        return str_replace('_', ' ', $word);
    }
}
