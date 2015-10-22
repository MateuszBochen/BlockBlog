<?php

namespace System\Render;

use Atline\Atline\Engine;


class Render
{
    private $atLine;
    private $cacheDir;
    private $configs;

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
        return $this->atLine->render($template, $data);
    }
    
}