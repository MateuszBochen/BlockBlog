<?php

define('ROOT_DIR', realpath(dirname(__FILE__).'/../'));

include ('/../System/Autoloader/Autoloader.php');
include ('/../System/Kernel.php');
include ('../vendor/autoload.php');

$kernel = new \System\Kernel;

$kernel->init();
