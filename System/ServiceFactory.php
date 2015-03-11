<?php
namespace System;

class ServiceFactory
{
    static private $loadedClasses = [];
    
    public function addClass($className)
    {
       self::$loadedClasses[] = $className;
    }
    
    public function getLoadedClasses()
    {
        return self::$loadedClasses;
    }
}
