<?php

namespace System\AppLauncher;

use System\Http\Response\Response;
use System\AppLauncher\Admin;

class AdminAppLauncher
{
    private $serviceFactory;
    private $configuration;
    private $adminRouting;
    private $loginUrl = 'login';
    private $authenticateUrl = 'authenticate';
    private $render;
    private $loadDataFromApps;
    private $initValues = [];
    private $urlParams = [];

    public function __construct($serviceFactory, $configuration)
    {
        $response = new Response();

        $this->serviceFactory = $serviceFactory;
        $this->configuration = $configuration;

        $request = $serviceFactory->getService('request');
        $this->urlParams = $request->getUrlParams();
        $currentUrl = $request->getCurrentUrl();
        $currentUrl = $this->clearCurrentUrlFromAdminDir($currentUrl);

        $authentication = $serviceFactory->getService('authentication');
        $isAuthorized = $authentication->isAuthorize();

        $this->loadDataFromApps = new Admin\Loaders\RoutingDataSeparator();        

        if ($currentUrl != $this->authenticateUrl && $currentUrl != $this->loginUrl && $isAuthorized == false) {
            $response->redirect($configuration->getParam('adminDir').'/'.$this->loginUrl);
        }

        $app = $this->getAppFromRouting($currentUrl);
        $responseClass = call_user_func_array([$app, 'init'], $this->initValues);

        if ($responseClass instanceof \System\Render\Render) {
           $response->html($responseClass->getView());
        }
        elseif($responseClass instanceof \System\Http\Response\Response) {
            //$response->html($class->getView());
            // just code here something 
        }
        else {
            throw new AppLauncherException('Init app must return render object or response object ');
        }
    }

    private function getAppFromRouting($url) 
    {
        $routeClass = new Admin\Routing($this->urlParams, $this->loadDataFromApps->getRoutingData());
        $appName = $routeClass->getAppName($url);

        if (!$appName) {
            throw new AppLauncherException('Route <b>'.$currentUrl.'</b> does not exist ');
        }

        if (!method_exists ($appName, 'init')) {
            throw new AppLauncherException('Method <b>init()</b> does not exist in <b>'.$appName.'</b>');
        }

        return $this->initApp($appName);
    }

    private function clearCurrentUrlFromAdminDir($url)
    {
        return trim(str_replace($this->configuration->getParam('adminDir'), '', $url), '/');
    }

    private function initApp($className)
    {
        $reflection = new \ReflectionClass($className);
        $method = $reflection->getMethod('init');
        $methodParameters = $method->getParameters();
        $initArgumentsList = $this->createInitArguments($methodParameters);
        //$this->baseUrl = str_replace('\/', '/', $this->baseUrl);

        return $reflection->newInstanceArgs([$this->serviceFactory, $this->configuration, $this->prepareAdminEnvironment($initArgumentsList)]);
    }

    private function createInitArguments($params)
    {
        $argumentsListToConstructor = [];

        foreach ($params as $param) {

            $value = array_search($param->name, $this->urlParams);

            if($value === false) {
                if($param->isOptional()) {
                    $argumentsListToConstructor[$param->name] = $param->getDefaultValue();
                    $this->initValues[] = $param->getDefaultValue();
                    continue;
                }
                else {
                    throw new Admin\RoutingException("Invalid params for this routing");
                }
            }

            if(!isset($this->urlParams[$value+1])){
                throw new Admin\RoutingException("Invalid params for this routing");
            }

            $argumentsListToConstructor[$param->name] = $this->urlParams[$value+1];
            $this->initValues[] = $this->urlParams[$value+1];
        }

        return $argumentsListToConstructor;
    }

    private function prepareAdminEnvironment($initArguments)
    {
        $menu = new \System\AppLauncher\Admin\MenuBuilder(
            $this->loadDataFromApps->getMenuData(),
            $this->serviceFactory->getService('request'),
            $this->serviceFactory->getService('translator'),
            $this->configuration->getParam('adminDir')
        );

        return new \System\Render\AdminEnvironment(
            $this->serviceFactory->getService('request'),
            $this->serviceFactory->getService('notifications'),
            $this->serviceFactory->getService('user.active'),
            $this->configuration->getParam('adminDir'),
            $initArguments,
            '',
            $menu
        );
    }
}
