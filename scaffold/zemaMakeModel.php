<?php
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * zemaMakeModel
 **/
class zemaMakeModel implements zemaMakeInterface {
    
    public function make(Scaffold $obj) {
        $className = ucfirst($obj->fileName);
        $getOneMethod = Scaffold::$getOneMethod;
        $getAllMethod = Scaffold::$getAllMethod;
        $model = <<<CLASS
<?php

class  $className{

    public function __construct() {
        Db::connect();
    }
    //ToDo Exception handling
   
    $getOneMethod
    
    $getAllMethod
}
CLASS;

        return $model;
    }
}
