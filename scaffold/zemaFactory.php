<?php
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * zemaFactory
 **/
require_once realpath(__DIR__).'/../app/core/exceptions/PDOstatementException.php';
require_once realpath(__DIR__).'/../app/core/exceptions/ResourceNotFoundException.php';
require_once realpath(__DIR__).'/../app/config.php';
require_once realpath(__DIR__).'/../app/core/db.php';

spl_autoload_register(function ($class){
    require_once $class.'.php';
});

class zemaFactory {
    /**
     * @param $argv
     * @return mixed
     * @throws Exception
     */
    public static function getObjectType($type) {
        // construct our class name and check its existence
        $class = 'zemaMake' . ucfirst($type);
        // return a Writer object
        if(class_exists($class)) {
            return new $class();
        }
        // otherwise we fail
        throw new Exception("Unsupported Type [$type]");
    }
}
