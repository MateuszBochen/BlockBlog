<?php

namespace System\Render;

use Atline\Engine;
use Atline\Environment;

class Render
{
    private $atLine;

    public function __construct($cacheDir, $render)
    {
        $cacheDir = ROOT_DIR.'/'.$cacheDir.'/'.$render['cacheDir'];

        $this->atLine = new Engine($cacheDir, new Environment());
        $this->atLine->setCached($render['cachedRender']);
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
