<?php

namespace System\AppLauncher;

class AdminAppLauncher
{
    private $serviceFactory;
    private $configuration;
    private $adminRouting;
    private $loginUrl = 'login';
    private $authenticateUrl = 'authenticate';
    private $render;

    public function __construct($serviceFactory, $configuration)
    {
        $this->serviceFactory = $serviceFactory;
        $this->configuration = $configuration;

        $request = $serviceFactory->getService('request');
        $currentUrl = $request->getCurrentUrl();

        //$this->loginUrl = $configuration->getParam('adminDir').$this->loginUrl;
        //$this->authenticateUrl = $configuration->getParam('adminDir').$this->authenticateUrl;

        $authentication = $serviceFactory->getService('authentication');
        $isAuthorized = $authentication->isAuthorize();

        $currentUrl = $this->clearCurrentUrlFromAdminDir($currentUrl);

        $app = $this->getAppFromRouting($currentUrl);

        if ($currentUrl != $this->authenticateUrl && $currentUrl != $this->loginUrl && $isAuthorized == false) {
            $serviceFactory->getService('response')->redirect($configuration->getParam('adminDir').'/'.$this->loginUrl);
        }

        $app->init();
    }

    private function getAppFromRouting($url) 
    {
        $routeClass = new \System\AppLauncher\Admin\Routing();
        return $routeClass->getApp($url, $this->serviceFactory, $this->configuration);
    }

    private function clearCurrentUrlFromAdminDir($url)
    {
        return trim(str_replace($this->configuration->getParam('adminDir'), '', $url), '/');
    }

}
