<?php

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    echo '<pre>';

    //$trace = array_reverse(debug_backtrace());
    //echo 'dupa'."\n";
    //print_r($trace);

/*  print_r($errno);
    print_r($errstr);
    print_r($errfile);
    print_r($errline);*/
    /*if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
        
    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }*/

    /* Don't execute PHP internal error handler */
    return true;
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
