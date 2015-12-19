<?php

namespace MainApp\Pages\Ajax;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;
use System\Http\Response\Response;

class Visibility extends BaseApp
{
    public function init($id, $newVisibility)
    {
        $orm = $this->get('orm');
        $notifications = $this->get('notifications');

        $pageRepository = $orm->getRepository('MainApp\Pages\Entities\Page');

        $page = $pageRepository->findOneBy(['id' => $id]);
        $page->setDisabled($newVisibility);

        $orm->add($page);
        $orm ->save();

        return (new Response())->jsonArray(['ok']);
    }
}
