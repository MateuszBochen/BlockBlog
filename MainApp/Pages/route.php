<?php

return [
    'pages/create' => 'MainApp\\Pages\\Create',
    'pages/save' => 'MainApp\\Pages\\Save',
    'pages/list/{page:d}' => 'MainApp\\Pages\\ListPages',
    'pages/delete/{id:d}' => 'MainApp\\Pages\\Manager\\DeletePage',
    'pages/visibility/{id:d}/{newVisibility:d}' => 'MainApp\\Pages\\Ajax\\Visibility',
];
