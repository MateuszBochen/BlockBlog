<?php

namespace System\Render;

use Atline\Atline\Environment;

class AdminEnvironment extends Environment
{
    private $request;
    private $notifications;
    private $admindir;
    private $user;

    public $appName;
    public $appSubName;

    public function __construct($request, $notifications, $user, $admindir)
    {
        $this->request = $request;
        $this->notifications = $notifications;
        $this->admindir = $admindir;
        $this->user = $user->getUser();
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
        return $this->request->getApplicatopnPath().'/'.$this->admindir.'/'.trim($url, '/');
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
