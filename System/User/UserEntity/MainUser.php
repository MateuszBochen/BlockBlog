<?php

namespace System\User\UserEntity;

class MainUser
{
    protected $id;
    protected $userName;
    protected $password;
    protected $eMail;
    protected $createdAt;
    protected $range;
    protected $userToken;

    public function __construct()
    {
        if (!$this->createdAt) {
            $this->createdAt = time();
        }
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
        
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        
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

    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;
        
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

    public function getUserToken()
    {
        $this->userToken;
    }
}
