<?php

namespace System\AppLauncher\Admin\ExtendsClass;

use System\ServiceFactory\ServiceFactory;

class BaseApp implements BaseInterface
{
    private $serviceFactory;
    private $configuration;

    protected $render;


    public function __construct(ServiceFactory $sf, $configuration)
    {
        $this->serviceFactory = $sf;
        $this->configuration = $configuration;

        $resolver = new \System\Render\AdminResolver();

        $r = $this->serviceFactory->getService('render.admin.environment');

        $this->render = $this->serviceFactory->getService('render');
        $this->render->setEnvironment($r);
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
