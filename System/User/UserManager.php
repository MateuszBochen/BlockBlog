<?php

namespace System\User;

use System\User\UserEntity\MainUser;

class UserManager
{
    private $orm;
    private $userRepository;

    public function __construct($orm)
    {
        $this->orm = $orm;

        $this->userRepository = $this->orm->getRepository('System\User\UserEntity\MainUser');
    }

    public function getUserBy($id)
    {
        

        //$user = $this->crud->read(new MainUser(), ['id' => $id]);

        return $this->userArray[$user->getId()] = $user;
    }

    public function getUserByToken($token)
    {
        return $this->userRepository->findOneBy(['userToken' => $token]);
    }
    
    public function createUser($userName, $password, $eMail, $range)
    {
        $user = new MainUser();
        
    }

    public function getUserByLogin($login, $password)
    {
        return $this->userRepository->findOneBy(['userName' => $login]);
    }
    
    public function passwordHash($password, $createdAt)
    {
        return sha1($password.'.'.$createdAt);
    }
}
