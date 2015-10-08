<?php

namespace System\Authentication;

class Authentication
{
    private $request;
    private $session;
    private $userManager;
    
    private $userToken;
    private $authenticationToken;

    public function __construct($request, $session, $userManager)
    {
        $this->request = $request;
        $this->session = $session;
        $this->userManager = $userManager;
        
        $this->authenticationToken = $this->session->get('authentication.token');
        $this->userToken = $this->session->get('user.token');
    }

    public function isAuthorize()
    {
        $user = $this->userManager->getUserByToken($this->userToken);

        $token = $this->createAuthenticationToken($user);

        if ($token == $this->authenticationToken) {
            return true;
        }

        return false;
    }

    public function authorize($login, $password)
    {
        $user = $this->userManager->getUserByLogin($login);
        $password = $this->userManager->passwordHash($password, $user->getCreatedAt());

        if ($password != $user->getPassword()) {
            return false;
        }

        $newToken = $this->createAuthenticationToken($user);

        $this->session->set('authentication.token', $newToken);
        $this->session->set('user.token', $user->getUserToken());

        return $user->getUserToken();
    }

    public function unAuthorize()
    {
        $this->session->set('authentication.token', '');
        $this->session->set('user.token', '');
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
