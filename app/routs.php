<?php
/**
 * Created by PhpStorm.
 * Author: Mohammad Homayoon Fayez
 * Date: 02-05-2017
 * Time: 08:07
 */

//Note: in this version the routes with variables like $id should always be at the end
Router::parseUrl();
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    Router::get('home', 'Homes@index');
    Router::get('articles', 'Articles@getTitles');
    Router::get('users/login', 'Users@getLoginForm');
    Router::get('users/logout', 'Users@logout');
    Router::get('articles/$id', 'Articles@getArticle');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    Router::post('articles/save', 'Articles@saveArticle');
    Router::post('users/save', 'Users@addUser');
    Router::post('users/login', 'Users@login');
}
if($_SERVER['REQUEST_METHOD'] == 'PUT') {
  //  Router::put('articles/edit', 'Articles@editArticle');
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  //  Router::delete('articles/delete/$id', 'Articles@confirmDelete');
}

Router::notFound();