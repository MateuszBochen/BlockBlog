<?php

namespace MainApp\Authorization;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Logout extends Base
{
    public function init()
    {
        $authentication = $this->get('authentication');
        $request = $this->get('request');

        $authentication->unAuthorize();

        $this->get('response')->redirect($this->getParam('adminDir').'/'.$this->loginUrl);
    }
}
