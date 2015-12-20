<?php

namespace System\AppLauncher\Admin\ExtendsClass;

use System\ServiceFactory\ServiceFactory;

class BaseApp implements BaseInterface
{
    public $appName = '';
    public $appSubName = '';

    private $serviceFactory;
    private $configuration;
    private $environment;

    protected $render;

    public function __construct(ServiceFactory $sf, $configuration, $params, $mainUrl)
    {
        $this->serviceFactory = $sf;
        $this->configuration = $configuration;

        $className = get_class($this);

        $resolver = new \System\Render\AdminResolver();
        $resolver->setClassName($className);

        $this->environment = new \System\Render\AdminEnvironment(
            $this->serviceFactory->getService('request'),
            $this->serviceFactory->getService('notifications'),
            $this->serviceFactory->getService('user.active'),
            $this->configuration->getParam('adminDir'),
            $params,
            $mainUrl
        );

        $this->environment->appName = $this->appName;
        $this->environment->appSubName = $this->appSubName;

        $this->render = $this->serviceFactory->getService('render');
        $this->render->setEnvironment($this->environment);
        $this->render->setDefinitionResolver($resolver);
    }

    protected function setAppName($appName)
    {
        $this->environment->appName = $appName;

        return $this;
    }

    protected function get($name)
    {
        return $this->serviceFactory->getService($name);
    }

    protected function getParam($name)
    {
        return $this->configuration->getParam($name);
    }
}
