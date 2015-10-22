<?php

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    echo '<pre>';

    //$trace = array_reverse(debug_backtrace());
    //echo 'dupa'."\n";
    //print_r($trace);

    echo '['.$errno.'] '.$errstr."\n";
    echo '['.$errline.'] '.$errfile.' '.$errline."\n";

    exit();

}

set_error_handler("myErrorHandler");

function exception_handler($exception) {
  echo '<div class="alert alert-danger">';
  echo '<b>Fatal error</b>:  Uncaught exception \'' . get_class($exception) . '\' with message ';
  echo $exception->getMessage() . '<br>';
  echo 'Stack trace:<pre>' . $exception->getTraceAsString() . '</pre>';
  echo 'thrown in <b>' . $exception->getFile() . '</b> on line <b>' . $exception->getLine() . '</b><br>';
  echo '</div>';
}

set_exception_handler('exception_handler');


define('ROOT_DIR', realpath(dirname(__FILE__).'/..'));

include (ROOT_DIR.'/System/Autoloader/Autoloader.php');
include (ROOT_DIR.'/System/Kernel.php');
include (ROOT_DIR.'/vendor/autoload.php');

$kernel = new \System\Kernel;

$kernel->init();
