<?php
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * zemaMakeController
 **/
class zemaMakeController implements zemaMakeInterface {

    public function make(Scaffold $obj) {
        $className = ucfirst($obj->controllerName);
        $getIndexMethod = Scaffold::$getIndexMethod;
        $getTitlesMethod = Scaffold::$getTitlesMethod;
        $getArticleMethod = Scaffold::$getArticleMethod;

        $app = <<<APP
<?php
/**
 * Auto generated class
 **/
class  $className extends Controller{

    public function __construct() {
        \$this->init();
        //gets the model
        \$this->articleModel =  \$this->model('Article');
        \$this->view('main');
        //enable  the partials you want to  use on this page.
        //the partials must exist in the partial folder
        \$this->partial(['_main-menu', '_aside-list']);
        //It's better to create the article list in constructor, otherwise we have to recreate it in each method
        //get articles titles
        \$titles = \$this->articleModel->getAll();
        //create Menu using articles titles
        \$menu = \$this->make(\$titles, 'a', 'href = '.ZEMA_ROOT.'/articles')->addTag('li')->get();
        \$this->setTag(TAGS['aside_menu'], \$menu);
    }
   
    $getTitlesMethod
    
    $getArticleMethod

}
APP;
        $class = <<<CLASS
<?php
/**
 * Auto generated class
 **/
class  $className extends Controller{

    public function __construct() {
        \$this->init();
        \$this->view('main');
        //if you set partials in the constructor, they will be available in all the methods of this class
        \$this->partial('_main-menu');
    }

    $getIndexMethod

}
CLASS;
        if($obj->viewName === 'app') {
            $controller = $app;
        }else{
            $controller = $class;
        }

        return $controller;
    }
}
