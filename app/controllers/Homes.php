<?php
/**
 * Auto generated class
 **/
class  Homes extends Controller{

    public function __construct() {
        $this->init();
        $this->view('main');
        //if you set partials in the constructor, they will be available in all the methods of this class
        $this->partial('_main-menu');
    }

        /**
     * auto generated method
     * @return void
     */
    public function index()
    {
        $this->partial('_welcome');
        exit($this->create());
    }

}