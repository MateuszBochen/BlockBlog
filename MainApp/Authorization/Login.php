<?php

namespace MainApp\Authorization;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Login extends Base
{

    public function init()
    {
        return $this->render->single('login', []);
    }

}
