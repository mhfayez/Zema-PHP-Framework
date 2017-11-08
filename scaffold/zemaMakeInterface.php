<?php

/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * zemaMakeInterface
 **/

interface zemaMakeInterface {
    /* Any classes implementing the Writer interface will be sure to have this write method.*/
    
    //type hints: it only accepts objects of type Scaffold
    public function make(Scaffold $obj);
}
