<?php

namespace System\AppLauncher;

use System\Http\Response\Response;

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
        $response = new Response();

        $this->serviceFactory = $serviceFactory;
        $this->configuration = $configuration;

        $request = $serviceFactory->getService('request');
        $currentUrl = $request->getCurrentUrl();

        $authentication = $serviceFactory->getService('authentication');
        $isAuthorized = $authentication->isAuthorize();

        $currentUrl = $this->clearCurrentUrlFromAdminDir($currentUrl);

        $app = $this->getAppFromRouting($currentUrl, $request->getUrlParams());

        if ($currentUrl != $this->authenticateUrl && $currentUrl != $this->loginUrl && $isAuthorized == false) {
            $response->redirect($configuration->getParam('adminDir').'/'.$this->loginUrl);
        }

        if ($app[0] === false) {
            throw new AppLauncherException('Route <b>'.$currentUrl.'</b> does not exist ');
        }

        $class = call_user_func_array([$app[0], 'init'], $app[1]);

        if ($class instanceof \System\Render\Render) {
           $response->html($class->getView());
        }
        elseif($class instanceof \System\Http\Response\Response) {
            //$response->html($class->getView());
            // just code here something 
        }
        else {
            throw new AppLauncherException('Init app must return render object or response object ');
        }
    }

    private function getAppFromRouting($url, $params) 
    {
        $routeClass = new \System\AppLauncher\Admin\Routing($params);
        $app = $routeClass->getApp($url, $this->serviceFactory, $this->configuration);
        $initValues = $routeClass->getIniValues();

        return [$app, $initValues];
    }

    private function clearCurrentUrlFromAdminDir($url)
    {
        return trim(str_replace($this->configuration->getParam('adminDir'), '', $url), '/');
    }
}
