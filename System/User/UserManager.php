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
        return sha1($password.'.'.$createdAt);
    }
}
