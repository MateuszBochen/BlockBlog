<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;
use System\Http\Form\Validators;

class Create extends BaseApp
{
    public $appName = 'Create new page';

    public function init()
    {
        $request = $this->get('request');
        $page = new Entities\Page();

        if ($request->isPost()) {
            $this->save($page);
        }

        return $this->render->base('newPage', ['page' => $page]);
    }


    private function save($page)
    {
        $this->orm = $this->get('orm');
        $notifications = $this->get('notifications');

        $form = $this->get('form');
        $form->setEntity($page);
        $form->addRule('pageName', new Validators\NotEmpty());
        $form->addRule('pageUrl', new Validators\NotEmpty());
        $form->addRule('pageStructJson', new Validators\NotEmpty());

        if($form->valid()) {
            $this->orm->add($page);
            $this->orm->save();

            $notifications->add('Page was created', 'success');
        }
        else {
            $errors = $form->getErrors();
            $message = '';

            foreach ($errors as $name => $messages) {
                $message .= $messages['name'].': '.implode(', ', $messages['messages']).'<br />';
            }

            $notifications->add($message, 'error');
        }
    }
}
