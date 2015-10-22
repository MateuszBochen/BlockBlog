<?php 

namespace System\Render;

use Atline\Atline\DefinitionResolver;

class AdminResolver extends DefinitionResolver
{
    public function resolve($definition)
    {
        return ROOT_DIR."/public/Admindir/{$definition}.tpl.html";
    }
}