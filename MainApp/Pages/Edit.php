<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;
use System\Http\Form\Validators;

class Edit extends BaseApp
{
    public $appName = 'Edit page: ';

    public function init($id)
    {
        $orm = $this->get('orm');
        $request = $this->get('request');
        $notifications = $this->get('notifications');

        $pageRepository = $orm->getRepository('MainApp\Pages\Entities\Page');
        $page = $pageRepository->findOneBy(['id' => $id]);

        if ($request->isPost()) {
            $form = $this->get('form');
            $form->setEntity($page);
            $form->addRule('pageName', new Validators\NotEmpty());
            $form->addRule('pageUrl', new Validators\NotEmpty());
            $form->addRule('pageStructJson', new Validators\NotEmpty());

            if($form->valid()) {
                $orm->add($page);
                $orm->save();

                $notifications->add('Page was updated', 'success');
            }
        }

        

        $this->setAppName($this->appName . $page->getPageName());

        return $this->render->base('newPage', ['page' => $page]);
    }
}
