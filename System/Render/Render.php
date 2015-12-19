<?php

namespace System\Render;

use Atline\Atline\Engine;


class Render
{
    private $atLine;
    private $cacheDir;
    private $configs;
    private $view;


    public function __construct($cacheDir, $configs)
    {
        $this->configs = $configs;
        $this->cacheDir = ROOT_DIR.'/'.$cacheDir.'/'.$configs['cacheDir'];
    }

    public function setEnvironment($adminEnvironment)
    {
        $this->atLine = new Engine($this->cacheDir, $adminEnvironment);
        $this->atLine->setCached($this->configs['cachedRender']);
    }

    public function setDefinitionResolver($definitionResolver)
    {
        $this->atLine->setDefinitionResolver($definitionResolver);

        return $this; 
    }

    public function single($template, $data)
    {
        $this->view = $this->atLine->render($template, $data);

        return $this;
    }

    public function base($template, $data)
    {
        $this->atLine->setDefaultExtends('base');
        $this->view = $this->atLine->render($template, $data);

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }
}
