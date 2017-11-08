<?php
/**
 * Created by PhpStorm.
 * User: mhfay
 * Date: 9/2/2017
 * Time: 14:02
 */
class zemaMakeView implements zemaMakeInterface {


    public function make(Scaffold $obj)
    {

        $view = <<<MAINVIEW
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zema CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.4/foundation.min.css">
    <link rel="stylesheet" href="{ZEMA_ROOT}/css/app.css">
</head>
<body>

<div class="row">
    <div class="large-8 columns">
        {_MAIN-MENU}
        <hr/>
    </div>
    <div class="large-4  columns">
        {ZEMA_USER}
         <a style="float:right" class = "button primary tiny" href="{ZEMA_ROOT}/users/{ZEMA_AUTH_PATH}">{ZEMA_USER_STATUS}</a>
    </div>
</div>

<div class="row">
    <div class="large-9 columns" role="content">
        {_WELCOME}
        {_ARTICLE}
        {_LOGIN-FORM}
    </div>
    {_ASIDE-LIST}
</div>

<footer class="row">
    <div class="large-12 columns">
        <hr/>
        <div class="row">
            <div class="large-6 columns">
                <p>&copy; Copyright no one at all. Go to town.</p>
            </div>
        </div>
    </div>
</footer>
<script src="{ZEMA_ROOT}/js/app.js"></script>
</body>
</html>

MAINVIEW;

        $asideList = <<<PARTIALVIEW1
<aside class="large-3 columns">
    <h5>Articles</h5>
    <ul>
       {ZEMA_ASIDE_MENU}
    </ul>
</aside>
PARTIALVIEW1;

        $welcome = <<<PARTIALVIEW2
<article>
    <h6>Welcome</h6>
    <div class="row">
        <div class="large-6 columns">
            <p>We build too many walls and not enough bridges(Newton)</p>
        </div>
        <div class="large-6 columns">
            <img src="{ZEMA_ROOT}/images/paghman.jpg"/>
        </div>
    </div>
</article>
PARTIALVIEW2;

        $article = <<<PARTIALVIEW2
<article>
    <h3>{ZEMA_ARTICLE_TITLE}</h3>
    <h6>Written by <a href="#">Author</a> on May 12, 2017.</h6>
    <div class="row">
        <div class="large-6 columns" contenteditable="true">
            <p>{ZEMA_ARTICLE}</p>
        </div>
        <div class="large-6 columns">
            <img src="{ZEMA_ROOT}/images/{ZEMA_ARTICLE_IMAGE}"/>
        </div>
    </div>
</article>
PARTIALVIEW2;

        $mainMenu = <<<PARTIALVIEW3
<div class="nav-bar text-center right">
    <ul class="button-group">
        <a class="hollow button" href="{ZEMA_ROOT}/home">Home</a>
        <a class="hollow button" href="{ZEMA_ROOT}/docs">Docs</a>
        <a class="hollow button" href="{ZEMA_ROOT}/tutorials">Tutorials</a>
        <a class="hollow button" href="{ZEMA_ROOT}/contact">Contact</a>
        <a class="hollow button" href="{ZEMA_ROOT}/articles">Articles</a>
        <a class="hollow button" href="{ZEMA_ROOT}/about">About</a>
    </ul>
</div>
PARTIALVIEW3;

        $loginForm = <<<PARTIALVIEW4
<form action="{ZEMA_ROOT}/users/login" method="post">
    <label for="email">
        <input id="email" name="email" type="text">
    </label>
    <label for="password">
        <input id="password" name="password" type="password">
    </label>
    <input type="submit" name="submit" value="Login">
</form>
PARTIALVIEW4;


        if($obj->viewName === 'app') {
            $views = array($view, $asideList, $welcome, $article, $mainMenu, $loginForm);
        }else{
            $views = $view;
        }

        return $views;
    }
}