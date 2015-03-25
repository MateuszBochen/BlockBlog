<?php

namespace System\User\UserEntity;

use Simplon\Mysql\Crud\SqlCrudVo;
use System\User\UserEnum\Rangs;

class UserEntity extends SqlCrudVo
{
    private $id;
    private $userName;
    private $password;
    private $eMail;
    private $createdAt;
    private $range;
    
    public function __construct()
    {
        $this->createdAt = time();
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
        
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }

    public function setEMail($eMail)
    {
        $this->eMail = $eMail;
        
        return $this;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    public function setRange($range)
    {
        $this->range = $range;
        
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEMail()
    {
        return $this->eMail; 
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getRange()
    {
        $this->range;
    }
}
