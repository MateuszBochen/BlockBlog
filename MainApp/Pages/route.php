<?php

return [
    'pages_page_create' => [
        'url' => 'pages/create',
        'class' => 'MainApp\\Pages\\Create',
        'name' => 'create_new_page',
        'showIn' => 'MAIN_MENU',
        'icon' => 'fa-file-o'
    ],
    'pages_page_edit' => [
        'url' => 'pages/edit/{id:d}',
        'class' => 'MainApp\\Pages\\Edit',
    ],
    'pages_page_save' => [
        'url' => 'pages/save',
        'class' => 'MainApp\\Pages\\Save',
        'name' => 'save',
        'showIn' => 'APP_MAIN_MENU'
    ],    
    'pages_page_list' => [
        'url' => 'pages/list/{page:d}',
        'class' => 'MainApp\\Pages\\ListPages',
        'name' => 'show_pages',
        'showIn' => 'MAIN_MENU',
        'icon' => 'fa-th-list'
    ],
    'pages_page_delete' => [
        'url' => 'pages/delete/{id:d}',
        'class' => 'MainApp\\Pages\\Manager\\DeletePage'
    ],
    'pages_page_visibility' => [
        'url' => 'pages/visibility/{id:d}/{newVisibility:d}',
        'class' => 'MainApp\\Pages\\Ajax\\Visibility'
    ],

    /*'
    //'pages/create' => 'MainApp\\Pages\\Create',
    //'pages/edit/{id:d}' => 'MainApp\\Pages\\Edit',
    //'pages/save' => 'MainApp\\Pages\\Save',
    //'pages/list/{page:d}' => 'MainApp\\Pages\\ListPages',
    //'pages/delete/{id:d}' => 'MainApp\\Pages\\Manager\\DeletePage',
    //'pages/visibility/{id:d}/{newVisibility:d}' => 'MainApp\\Pages\\Ajax\\Visibility',*/
];
