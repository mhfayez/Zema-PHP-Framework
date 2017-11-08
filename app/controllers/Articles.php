<?php
/**
 * Auto generated class
 **/
class  Articles extends Controller{

    public function __construct() {
        $this->init();
        //gets the model
        $this->articleModel =  $this->model('Article');
        $this->view('main');
        //enable  the partials you want to  use on this page.
        //the partials must exist in the partial folder
        $this->partial(['_main-menu', '_aside-list']);
        //It's better to create the article list in constructor, otherwise we have to recreate it in each method
        //get articles titles
        $titles = $this->articleModel->getAll();
        //create Menu using articles titles
        $menu = $this->make($titles, 'a', 'href = '.ZEMA_ROOT.'/articles')->addTag('li')->get();
        $this->setTag(TAGS['aside_menu'], $menu);
    }
   
         /**
     *Method articles gets all the articles titles
     */
    public function getTitles()
    {
        //the list is already generated in the controller
        //so just hide the unused partials and call create() method to create the view
        //$this->hide([TAGS['article_title'], TAGS['article']]);
        //if you want to show some default text then you can do the following
        $this->partial('_article');
        $this->setTag(TAGS['article_title'],'');
        $this->setTag(TAGS['article_image'],'paghman.jpg');
        $this->setTag(TAGS['article'],'Find the articles of your interest. ');
        exit($this->create());
    }
    
        /**
     * Gets article  by id
     * Then sets the title, body and image tags
     * @param $id
     */
    public function getArticle($id)
    {
        $this->partial('_article');
        $article = $this->articleModel->getOne($id);
        $this->setTag(TAGS['article_title'],$article['title']);
        // concerned with security? then either htmlspecialchars it on saving or 
        //on displaying or allow only specific tags if you trust the users
        $this->setTag(TAGS['article'],$article['body']);
        //$this->setArticle(htmlspecialchars($article['body']));
        $this->setTag(TAGS['article_image'],$article['image']);

        exit($this->create());
    }

}