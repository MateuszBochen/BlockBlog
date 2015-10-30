<?php

namespace System\Authentication;

class Authentication
{
    private $request;
    private $session;
    private $userManager;
    private $activeUser;
    
    private $userLogin;
    private $authenticationToken;

    public function __construct($request, $session, $userManager, $activeUser)
    {
        $this->request = $request;
        $this->session = $session;
        $this->userManager = $userManager;
        $this->activeUser = $activeUser;
        
        $this->authenticationToken = $this->session->get('authentication.token');
        $this->userLogin = $this->session->get('user.login');
    }

    public function isAuthorize()
    {
        $user = $this->userManager->getUserByLogin($this->userLogin);

        if ($user == false) {
            return false;
        }

        $token = $this->createAuthenticationToken($user);

        if ($token == $this->authenticationToken) {
            $this->activeUser->setUser($user);
            return true;
        }

        return false;
    }

    public function authorize($login, $password)
    {
        $user = $this->userManager->getUserByLogin($login);

        if ($user == false) {
            return false;
        }

        $password = $this->userManager->passwordHash($password, $user->getCreatedAt());

        if ($password != $user->getPassword()) {
            return false;
        }

        $newToken = $this->createAuthenticationToken($user);

        $this->session->set('authentication.token', $newToken);
        $this->session->set('user.login', $login);

        $this->activeUser->setUser($user);

        return true;
    }

    public function unAuthorize()
    {
        $this->session->set('authentication.token', '');
        $this->session->set('user.token', '');

        $this->activeUser->setUser(null);
    }

    private function createAuthenticationToken($user)
    {
        $rawString = $user->getId().$user->getCreatedAt().$user->getUserToken().$this->getRealIp();

        return hash('sha256', $rawString);
    }

    private function getRealIp() {

        $client  = $this->request->getServerValue('HTTP_CLIENT_IP');
        $forward = $this->request->getServerValue('HTTP_X_FORWARDED_FOR');
        $remote  = $this->request->getServerValue('REMOTE_ADDR');

        if (filter_var($client, FILTER_VALIDATE_IP)) {
           return $client;
        }
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            return $forward;
        }

        return $remote;
    }
}
