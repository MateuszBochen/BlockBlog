<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class ListPages extends BaseApp
{
    public $appName = 'My pages';

    private $perPage = 15;

    public function init($page = 0)
    {
        $orm = $this->get('orm');
        $mysql = $this->get('db');

        $repo = $orm->getRepository('MainApp\Pages\Entities\Page');

        $pages = $repo->findAll([], ($this->perPage * $page), $this->perPage);
        $allPages = $repo->countAll();

        return $this->render->base('list', [
            'pages' => $pages,
            'allPages' => ceil($allPages/$this->perPage)
        ]);
    }
}
