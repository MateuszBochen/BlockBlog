<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Create extends BaseApp
{
    public $appName = 'Create new page';

    public function init()
    {
        return $this->render->base('newPage', []);
    }
}
