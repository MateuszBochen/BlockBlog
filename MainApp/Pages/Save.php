<?php

namespace MainApp\Pages;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;
use System\Http\Form\Validators;

class Save extends BaseApp
{
    private $page;
    private $orm;

    public function init()
    {
        $this->orm = $this->get('orm');
        $notifications = $this->get('notifications');

        $page = new \MainApp\Pages\Entities\Page();

        $form = $this->get('form');
        $form->setEntity($page);
        $form->addRule('pageName', new Validators\NotEmpty());
        $form->addRule('pageUrl', new Validators\NotEmpty());
        $form->addRule('pageStructJson', new Validators\NotEmpty());

        if($form->valid()) {
            $this->orm->add($page);
            $this->orm->save();

            $notifications->add('Page was created', 'success');
            $this->get('response')->redirect($this->getParam('adminDir').'/pages/create');
        }
        else {
            $errors = $form->getErrors();
            $message = '';

            foreach ($errors as $name => $messages) {
                $message .= $messages['name'].': '.implode(', ', $messages['messages']).'<br />';
            }

            $notifications->add($message, 'error');
            $this->get('response')->redirect($this->getParam('adminDir').'/pages/create');
        }
    }
}
