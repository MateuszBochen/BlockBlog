<?php

namespace System\User;

use System\User\UserEntity\MainUser;

class UserManager
{
    private $orm;
    private $userRepository;
    private $secret;

    public function __construct($orm, $secret)
    {
        $this->orm = $orm;
        $this->secret = $secret;

        $this->userRepository = $this->orm->getRepository('System\User\UserEntity\MainUser');
    }

    public function getUserById($id)
    {
        return $this->userArray[$user->getId()] = $user;
    }

    public function getUserByToken($token)
    {
        return $this->userRepository->findOneBy(['userToken' => $token]);
    }
    
    // TODO
    public function createUser($userName, $password, $eMail, $range)
    {
        $user = new MainUser();
        $user->setUserName($userName)
            ->setPassword($this->passwordHash($password, $user->getCreatedAt()))
            ->setEMail($eMail)
            ->getRange($range);

        $this->orm->add($user);
        $this->orm->save();
    }

    public function getUserByLogin($login)
    {
        return $this->userRepository->findOneBy(['userName' => $login]);
    }
    
    public function passwordHash($password, $createdAt)
    {
        return hash('sha512', $password.'.'.$createdAt.'.'.$this->secret);
    }
}
