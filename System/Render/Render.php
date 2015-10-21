<?php

namespace System\Render;

use Atline\Atline\Engine;


class Render
{
    private $atLine;

    public function __construct($cacheDir, $render)
    {
        $cacheDir = ROOT_DIR.'/'.$cacheDir.'/'.$render['cacheDir'];

        $this->atLine = new Engine($cacheDir, new AdminEnvironment());
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
