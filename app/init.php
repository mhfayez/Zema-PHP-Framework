<?php
/**
 * Created by PhpStorm.
 * Author: Mohammad Homayoon Fayez
 * Date: 02-05-2017
 */
session_start();
'ERROR_REPORTING';

spl_autoload_register(function ($class){
    if (strpos($class, 'Exception') !== false) {
        $path = DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."exceptions".DIRECTORY_SEPARATOR;
    }else {
        $path = DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR;
    }
    require_once realpath(__DIR__).$path."$class.php";
});

require_once realpath(__DIR__).'/config.php';
require_once realpath(__DIR__) . '/routs.php';