<?php

namespace System\User;

use System\User\UserEntity\MainUser;

class UserManager
{
    private $userArray = [];
    private $crud;

    public function __construct($crud)
    {
        $this->crud = $crud;
    }

    public function getUserBy($id)
    {
        if (isset($this->userArray[$id])) {
            return $this->userArray[$id];
        }

        $user = $this->crud->read(new MainUser(), ['id' => $id]);

        return $this->userArray[$user->getId()] = $user;
    }
    
    public function createUser($userName, $password, $eMail, $range)
    {
        $user = new MainUser();
        $user->setUserName($userName);
        $user->setPassword($this->passwordHash($password,  $user->getCreatedAt()));
        $user->setEMail($eMail);
        $user->setRange($range);
        $user->setRange($range);
        $user->setId(null);

        $user = $this->crud->create($user);

        return $user;
    }
    
    public function passwordHash($password, $createdAt)
    {
        return sha1($password.'.'.$createdAt);
    }
}
