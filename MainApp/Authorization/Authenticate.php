<?php

namespace MainApp\Authorization;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Authenticate extends Base
{
    public function init()
    {
        $authentication = $this->get('authentication');
        $request = $this->get('request');
        $notifications = $this->get('notifications');

        if ($authentication->authorize($request->post('login'), $request->post('password'))) {
            $this->get('response')->redirect($this->getParam('adminDir').'/');
        }
        else {
            $notifications->add('Your login or passwors is incorrect', 'error');
            $this->get('response')->redirect($this->getParam('adminDir').'/'.$this->loginUrl);
        }
    }
}
