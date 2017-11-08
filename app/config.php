<?php
//const ZEMA_ENVIRONMENT = 'production';
const ZEMA_ENVIRONMENT = 'development';

if(ZEMA_ENVIRONMENT == 'production') {
    define ('ERROR_REPORTING', error_reporting(E_ERROR));
} else if(ZEMA_ENVIRONMENT == 'development') {
    define('ERROR_REPORTING', error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE));
}
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:32
 */
const DEFAULT_ROUT = 'home';
const DEFAULT_ACTION = 'index';
const DEFAULT_CONTROLLER = 'Home';

const DB_DSN = "mysql:host=localhost;dbname=zemaDb;charset=utf8"; //set the dbname and hostname
const DRIVER = 'mysql';
const HOST = 'localhost';
const USERNAME = 'root'; //set it to your own database user
const PASSWORD = ''; //set it to your own database password
const DATABASE = 'zemaDb'; //set it to your own database name
const CHARSET = 'utf8';
const COLLATION = 'utf8_unicode_ci';
const PREFIX = '';

if(!empty($_SERVER['HTTP_HOST'])) {
    define('ZEMA_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
}

//Tags used in views  and  partials
const TAGS = [
    'user'              =>  'zema_user',
    'user_status'       =>  'zema_user_status',
    'auth_path'         =>  'zema_auth_path',
    'main_menu'         =>  'zema_main_menu',
    'aside_menu'        =>  'zema_aside_menu',
    'article_id'        =>  'zema_article_id',
    'article_title'     =>  'zema_article_title',
    'article_image'     =>  'zema_article_image',
    'article'           =>  'zema_article',
    'content_id'        =>  'zema_content_id',
    'content_title'     =>  'zema_content_title',
    'content'           =>  'zema_content',
    'content_image'     =>  'zema_content_imgae',
    'author'            =>  'zema_author',
    'created'           =>  'zema_created',
    'updated'           =>  'zema_updated',
    'doc_title'         =>  'zema_doc_title',
    'default_content'   =>  'zema_default_content',
];

//this will be  used  to  create  the main menu  of  the site (you can use menu table from database, instead)
//CONSTRAINT: the keys must be named 'menu' and 'path'
const MAIN_MENU = [
    ['menu'=>'Home', 'path' => '/home'],
    ['menu'=>'Docs', 'path' => '/docs'],
    ['menu'=>'Tutorials', 'path' => '/tutorials'],
    ['menu'=>'Contact', 'path' => '/contact'],
    ['menu'=>'Articles', 'path' => '/articles'],
    ['menu'=>'About', 'path' => '/about']
];

//Error messages
const FORM_FIELDS_EMPTY = 'This field is required';
const PDO_STATEMENT_EXCEPTION_MESSAGE =
    '<strong style="color: red;">'.
        'An unexpected error  occurred.'.
    '</strong><br>'.
    'If it continues please contact the site Administrator';

const ERROR = [
    'username' => '<div class="large-12 columns text-center callout alert small">Invalid username</div>',
    'password' => '<div class="large-12 columns text-center callout alert small">Invalid password</div>',
    'required' => 'This field is required',
    'pdo-statement-exception' =>
        '<strong style="color: red;">'.
        'An unexpected error  occurred.'.
        '</strong><br>'.
        'please contact the site Administrator',
    'resource-not-found' => '<div class="large-12 columns text-center callout alert small">Resource not Found</div>',
    'file-not-found' => '<p style="color: red;">file not found. Check  log file  for more</p>',
    'rout-not-found' => '<span style="color: red;">Malformed rout, rout is not created in rout.php or'.
        ' Controller and Action method does not exist. </span>'.
        '<p>You can add a controller from the command prompt(console) by the following command</p>'.
        '<i> php make.php controller YourControllerName</i>'.
        '<p>Then add a route in routs.php e.g.</p>'.
        '<i> Router::get(\'home\', \'Homes@index\');</i>'
];