<?php

namespace System\Http\Session;

class Session
{
    private $sessionId;
    private $session = [];
    
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->sessionId = session_id();
        $this->session = $_SESSION;
    }
    
    public function __destruct()
    {
        $_SESSION = $this->session;
    }

    public function set($name, $value)
    {       
        $var = &$this->getFromArray($name);

        $var = $value;

        return $this;
    }

    public function get($name)
    {
        return $this->getFromArray($name);
    }

    private function &getFromArray($index)
    {
        $paramAsArray = explode('.', $index);
        $lastValue = &$this->session;

        foreach ($paramAsArray as $index) {
            if (!isset($lastValue[$index])) {
                $newVar = '';
                return $lastValue[$index] = &$newVar;
            }

            $lastValue = &$lastValue[$index];
        }

        return $lastValue;
    }
}
