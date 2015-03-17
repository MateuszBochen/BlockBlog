<?php

define('ROOT_DIR', dirname(__FILE__));

include ROOT_DIR.'/System/Autoloader/Autoloader.php';
include(ROOT_DIR.'/System/Kernel.php');

$kernel = new \System\Kernel;

$kernel->init();
