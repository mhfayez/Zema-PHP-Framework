<?php
    /**
    * The Router class. This is the main class which intercepts the requests and
    * delegates the task/responsibility to the appropriate class/controller.
     * Usage: Call from the browser: http://localhost/path_to_zemacms_public_folder_inside_your_webserver
     * path could For example be: zemacms/public/home
    **/
    include_once('exceptions/ResourceNotFoundException.php');
class Router
{
    /**
     * @var controller, name of the controller to  be invoked
     */
    protected static $controller = DEFAULT_CONTROLLER;
    /**
     * @var method, name of the method to  be invoked
     */
    protected static $method = DEFAULT_ACTION;
    protected static $uri;
    private static $url = DEFAULT_ROUT;
    private static $urlPart;
    /**
     * @var params, list of the parameters to be passed to  the method
     */
    protected static $params = [];
    private static $urlSize;
    private static $routSize;
    /**
     * Protected constructor
     */
    protected function __construct()
    {

    }
    /**
     * Protected static method parseUrl
     *
     * @return void
     */
    public static function parseUrl()
    {
        if(isset($_GET['url']))
        {
            self::$urlPart = array_filter(explode('/', filter_var (rtrim($_GET['url']), FILTER_SANITIZE_URL)));
            //the url itself e.g articles/1 or articles/php etc
            self::$url = rtrim($_GET['url'], '/');
            self::$urlSize = sizeof(self::$urlPart);

            $method='';

            if(isset($_POST['_METHOD'])){
                $method = trim($_POST['_METHOD']);
            }
            if($method === 'PUT'){
                $_SERVER['REQUEST_METHOD'] = 'PUT';
            }elseif($method === 'DELETE'){
                $_SERVER['REQUEST_METHOD'] = 'DELETE';
            }
        }
    }
    /**
     * @param $rout
     * @return bool
     */
    private static function parseRout($rout)
    {
        $routPart = explode('/', $rout);
        $routSize = sizeof($routPart);

        if($rout === self::$url) {
            return true;
        }elseif(stripos($rout, '$')!== false and ($routSize == self::$urlSize)){
            $totalVars = substr_count($rout, '$');
            for($i = 0; $i <= $routSize; $i++) {
                //compare elements of $rout and $url
                //if different and contains a $ sign then it is a variable push it  to  params array
                if(($routPart[$i] === self::$urlPart[$i])){
                    continue;
                }elseif(stripos($routPart[$i], '$')!== false){
                  //  echo "routPart: $i ".$routPart[$i].' urlPart: '.self::$urlPart[$i].'<br>';
                        array_push(self::$params, self::$urlPart[$i]);
                        for($i = 0; $i < sizeof(self::$params) - $totalVars; $i++){
                            unset(self::$params[$i]);
                        }
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        return false;
    }

    /**
     * Public method notFound
     * @return void
     */
    public static function notFound(){
        try{
            throw new ResourceNotFoundException('['. self::$url .'] '. ERROR['rout-not-found']);
        }catch(ResourceNotFoundException $e){
            echo $e->getMessage();
            exit();
        }
    }

    private static function setAction($handler){
        $at = explode('@', $handler);
        self::$controller = $at[0];
        self::$method = $at[1];
    }

    /**
     * Private method invokeMethod to invoke a method in a particular  controller
     *
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return void
     */
    private static function invokeMethod($controller, $method, array $params)
    {
        if(file_exists('../app/controllers/'.$controller.'.php')) {
            require_once '../app/controllers/'.$controller.'.php';
            if(method_exists($controller, $method)) {
                call_user_func_array([new $controller, $method], array('data'=>$params));
            }
        }
    }

    /**
     * @param $rout
     * @param $action
     */
    public static function get($rout, $action)
    {
        self::setAction($action);
        if(self::parseRout($rout)) {
            self::invokeMethod(self::$controller, self::$method, self::$params);
        }

    }

    /**
     * @param $rout
     * @param $action
     */
    public static function put($rout, $action)
    {
        unset($_POST['submit']);
        unset($_POST['_METHOD']);
        self::setAction($action);

        if (Validator::isEmpty($_POST)) {
            exit();
        } elseif(self::parseRout($rout)) {
            self::invokeMethod(self::$controller, self::$method, $_POST);
        }
    }

    /**
     * @param $rout
     * @param $action
     */
    public static function post($rout, $action)
    {
        //removes the submit button from the $_POST array
        unset($_POST['submit']);
        self::setAction($action);
       // var_dump($_POST);
        if (Validator::isEmpty($_POST)) {
            self::invokeMethod(self::$controller, 'error', array());
        }elseif(self::parseRout($rout)) {
            self::invokeMethod(self::$controller, self::$method, $_POST);
        }
    }

    public static function delete($rout, $action)
    {
        unset($_POST['submit']);
        unset($_POST['_METHOD']);
        self::setAction($action);
        if(self::parseRout($rout)) {
            self::invokeMethod(self::$controller, self::$method, self::$params);
        }
    }

}







