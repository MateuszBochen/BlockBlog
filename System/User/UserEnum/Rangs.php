<?php

namespace System\User\UserEnum;

class Rangs
{
    const SUPER_ADMIN = 999;
    const ADMIN = 500;
    const USER = 100;
    const GUEST = 0;
    
    private $range;
    
    public function __construct($range)
    {
        $this->range = $range;
    }
    
    public function getRange()
    {
        if ($this->range >= self::SUPER_ADMIN) {
            return self::SUPER_ADMIN;
        }
    }
}
