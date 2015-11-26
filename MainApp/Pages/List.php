<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class ListPages extends BaseApp
{
    public $appName = 'Create new page';

    public function init($param1)
    {
        return $this->render->base('newPage', []);
    }
}
