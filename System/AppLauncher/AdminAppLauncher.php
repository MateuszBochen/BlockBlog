<?php

namespace System\AppLauncher;

class AdminAppLauncher
{
    private $serviceFactory;
    private $configuration;
    private $adminRouting;    
    private $loginUrl = '/login';
    private $authenticateUrl = '/authenticate';
    private $render;

    public function __construct($serviceFactory, $configuration)
    {
        $this->serviceFactory = $serviceFactory;
        $this->configuration = $configuration;

        $resolver = new \System\Render\AdminResolver();

        $this->render = $this->serviceFactory->getService('render');
        $this->render->setEnvironment($this->serviceFactory->getService('render.admin.environment'));
        $this->render->setDefinitionResolver($resolver);

        $request = $serviceFactory->getService('request');
        $currentUrl = $request->getCurrentUrl();

        $this->loginUrl = $configuration->getParam('adminDir').$this->loginUrl;
        $this->authenticateUrl = $configuration->getParam('adminDir').$this->authenticateUrl;

        $authentication = $serviceFactory->getService('authentication');
        $isAuthorized = $authentication->isAuthorize();

        if ($currentUrl == $this->authenticateUrl) {           

            if ($authentication->authorize($request->post('login'), $request->post('password'))) {

            }
            else {
                $serviceFactory->getService('response')->redirect($this->loginUrl);
            }
        }
        elseif ($currentUrl != $this->loginUrl && $isAuthorized == false) {
            $serviceFactory->getService('response')->redirect($this->loginUrl);
        }
        elseif($currentUrl == $this->loginUrl) {
            $authentication->unAuthorize();

            echo $this->render->single('Login/login', []);
        }
    }

}
