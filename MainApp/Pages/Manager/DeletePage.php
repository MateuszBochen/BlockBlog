<?php

namespace MainApp\Pages\Manager;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;
use System\Http\Form\Validators;

class DeletePage extends BaseApp
{
    public function init($id)
    {
        $orm = $this->get('orm');
        $notifications = $this->get('notifications');

        $pageRepository = $orm->getRepository('MainApp\Pages\Entities\Page');

        $page = $pageRepository->findOneBy(['id' => $id]);

        $orm->add($page);

        $orm->delete();

        $notifications->add('Page was deleted', 'success');
        $this->get('response')->redirect($this->getParam('adminDir').'/pages/list');
    }
}
