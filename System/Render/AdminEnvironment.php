<?php

namespace System\Render;

use Atline\Atline\Environment;

class AdminEnvironment extends Environment
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
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

    // TODO
    public function t($word)
    {
        return str_replace('_', ' ', $word);
    }
}
