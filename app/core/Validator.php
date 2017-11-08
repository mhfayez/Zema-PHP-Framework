<?php

/**
 * Created by PhpStorm.
 * User: EASJ
 * Date: 04-06-2017
 * Time: 21:02
 */
class Validator
{
    public function  __construct()
    {

    }

    public static function isEmpty(array $fields)
    {
        $items = [];
        foreach ($fields as $field => $value){
            if(empty($value) || ctype_space($value)) {
                array_push($items, $field);
            }
        }
        if(sizeof($items) > 0){
            foreach ($items as $item){
                echo '[' . $item . '] is empty.'. ERROR['required'] .'<br>';
            }
            return true;
        }
        return false;
    }

}