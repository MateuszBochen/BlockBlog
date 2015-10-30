<?php 

namespace System\Render;

use Atline\Atline\DefinitionResolver;

class AdminResolver extends DefinitionResolver
{
    private $className = '';

    public function resolve($definition)
    {
        $file = '';

        if ($definition == 'base') {
            $file = ROOT_DIR."/public/Admindir/{$definition}.tpl.html";
        }
        else {
            $file = ROOT_DIR."/".$this->className."/view/{$definition}.tpl.html";
        }

        if (!file_exists($file)) {
            throw new \Exception("I can't find view <b>".$this->className."/view/{$definition}.tpl.html</b>");
        }

        return $file;
    }

    public function setClassName($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $tmp = explode('/', $className, -1);
        $className = implode('/', $tmp);
        $this->className = $className;
    }
}
