<?php

/**
 * Created by PhpStorm.
 * Users: EASJ
 * Date: 13-06-2017
 * Time: 18:59
 */
class Users extends Controller
{
    //private $user;

    public function __construct()
    {
       // $this->user = $this->model('Users');
        $this->init();
        $this->hide(['_article','_home', '_about', '_aside-list']);
        $this->partial(['_main-menu', '_login-form']);
        $this->view('main');
        //if you want to use the menu table  from Db
        //$menu = $this->model('Menu')->getMenu();
        //if you want to use the MAIN_MENU array from the  config file instead
        $menu  = MAIN_MENU;
        $main_menu = $this->makeMainMenu($menu);
        $this->setTag(TAGS['main_menu'],$main_menu);
    }

    public function getLoginForm()
    {
        echo "get login form";
        $this->hide('_add-user-form');
        $this->partial('_login-form');
        exit($this->create());
    }

    public function login($credentials)
    {
        $this->hide('_add-user-form');
            $login = $this->user->login($credentials);
            if ($login) {
                $this->redirect("articles");
            } else {
                //$this->redirect("users/login");
                echo $this->user->getError();

            }
        exit($this->create());
    }

    public function logout()
    {
        $this->user->logout();
        $this->hide('_add-user-form');
        //default behaviour:  remain on the same (login) page/UserController
        //If you want to redirect to  somewhere else user redirect(url);
        $this->redirect('articles');
        exit($this->create());
    }

    public function getAddUserForm()
    {
        $this->hide('_login-form');
        exit($this->create());
    }

    public function addUser($user)
    {
        $this->model('User')->register($user);
        exit($this->create());
    }

}