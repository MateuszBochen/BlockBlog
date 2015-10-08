<?php

namespace System\AppLauncher;

class AdminAppLauncher
{
    private $serviceFactory;
    private $configuration;
    private $adminRouting;    
    private $loginUrl = '/login';
    private $render;

    public function __construct($serviceFactory, $configuration)
    {
        $this->serviceFactory = $serviceFactory;
        $this->configuration = $configuration;

        $resolver = new \System\Render\AdminResolver();

        $this->render = $this->serviceFactory->getService('render');
        $this->render->setDefinitionResolver($resolver);

        $request = $serviceFactory->getService('request');

        $currentUrl = $request->getCurrentUrl();

        $this->loginUrl = $configuration->getParam('adminDir').$this->loginUrl;

        $authentication = $serviceFactory->getService('authentication');

        if ($currentUrl != $this->loginUrl && $authentication->isAuthorize() == false) {
            $serviceFactory->getService('response')->redirect($this->loginUrl);
        }
        elseif($currentUrl == $this->loginUrl) {
            $authentication->unAuthorize();

            echo $this->render->single('Login/login', []);
        }
    }

}
