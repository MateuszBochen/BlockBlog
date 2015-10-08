<?php

use Atline\View;

/**
 * View filepath: C:\xampp\htdocs\BlockBlog/public/Admindir/Login/login.tpl
 */
class Viewf51adfebb7b20c2c4e9110e9a0bb91670616e153c160c3e85a9e282ce6dd22ab extends View
{
    protected $sections = ['main' => 'main'];

    /**
     * Section name: main
     */
    public function main() {
        extract($this->data);
         echo  $this->section('head.bottom');  
    }
}