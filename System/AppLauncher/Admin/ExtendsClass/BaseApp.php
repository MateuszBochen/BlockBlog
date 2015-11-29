<?php

namespace System\AppLauncher\Admin\ExtendsClass;

use System\ServiceFactory\ServiceFactory;

class BaseApp implements BaseInterface
{
    public $appName = '';
    public $appSubName = '';

    private $serviceFactory;
    private $configuration;

    protected $render;

    public function __construct(ServiceFactory $sf, $configuration, $params, $mainUrl)
    {
        $this->serviceFactory = $sf;
        $this->configuration = $configuration;

        $className = get_class($this);

        $resolver = new \System\Render\AdminResolver();
        $resolver->setClassName($className);

        $environment = new \System\Render\AdminEnvironment(
            $this->serviceFactory->getService('request'),
            $this->serviceFactory->getService('notifications'),
            $this->serviceFactory->getService('user.active'),
            $this->configuration->getParam('adminDir'),
            $params,
            $mainUrl
        );

        $environment->appName = $this->appName;
        $environment->appSubName = $this->appSubName;

        $this->render = $this->serviceFactory->getService('render');
        $this->render->setEnvironment($environment);
        $this->render->setDefinitionResolver($resolver);
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
