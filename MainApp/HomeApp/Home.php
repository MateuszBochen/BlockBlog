<?php

namespace MainApp\HomeApp;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Home extends BaseApp
{

    public function init()
    {

        return $this->render->base('HomeApp/home', []);
    }
}
