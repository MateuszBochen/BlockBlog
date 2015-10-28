<?php

namespace MainApp\Authorization;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Login extends BaseApp
{

    public function init()
    {
        return $this->render->single('Login/login', []);
    }

}
