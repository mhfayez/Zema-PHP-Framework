<?php
/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * Make
 **/
require_once 'zemaFactory.php';

class Make {
    private $type;
    private $name;
    private $data;
    private $scaffold;
    private $fileCreated;

    /**
     * Make constructor: sets the command line arguments type and name of the resource to be used
     * in scaffold class
     * @param $argv
     */
    public function __construct($argv)
    {
        Db::connect();
        // grab request variable
        if(isset($argv)) {
            if (isset($argv[1]) && isset($argv[2])) {
                $this->type = $argv[1];
                if ($this->type != 'view') {
                    $this->name = ucfirst($argv[2]);
                } else {
                    $this->name = $argv[2];
                }
                $this->scaffold = new Scaffold($this->type, $this->name, false);
                $object = zemaFactory::getObjectType($this->type);
                $this->data = $this->scaffold->make($object);
                $this->fileCreated = $this->createFile();
            } else if($argv[1] === 'app') {
                try {
                            $sql = file_get_contents('sample.sql');
                            DB::handler()->exec($sql);
                            echo "Tables created successfully".PHP_EOL;
                            $types = ['model', 'controller', 'view'];
                            foreach ($types as $type){
                                $this->type = $type;

                                if($type === 'model') {
                                    $this->name = 'articles';
                                    $flag = true;
                                } else {
                                    $this->name = 'Articles';
                                    $flag = false;
                                }
                                $this->scaffold = new Scaffold($this->type, $this->name, $flag);
                                $this->scaffold->viewName = 'app';
                                $object = zemaFactory::getObjectType($this->type);
                                $this->data = $this->scaffold->make($object);
                                $this->fileCreated = $this->createFile();
                            }
                            self::__construct(['','controller', 'homes']);
                        }catch (Exception $e) {
                            $e->getMessage();
                        }
                    } else {
                echo 'Usage: php make.php [model/controller] [model/controller name]';
                exit();
            }
        }

        if($this->fileCreated){
            echo 'File created successfully at ['.$this->fileCreated.']'.PHP_EOL;
        }else {
            echo 'Somethings wrong with your command';
        }
    }

    /**
     * crateFile Method: sets the path, extension and file name of the
     * model, controller or view it has to create.
     * @return bool
     */
    private function createFile()
    {
        $res = false;
        $newpath = '';

        switch($this->type) {
            case 'model':
                $path = '../app/models/';
                $ext = '.php';
                break;
            case 'controller':
                $path = '../app/controllers/';
                $ext = '.php';
                break;
            case 'view':
                $path = '../app/views/';
                $ext = '.html';
                break;
            default:
                $path = '../app/';
        }
        //$file = strtolower($this->scaffold->tableName);
        $file = $this->scaffold->fileName;

        if(is_array($this->data)) {
            foreach ($this->data as $key => $datum) {
                switch ($key) {
                    case 0:
                        $newfile =  'main';
                        $newpath = $path;
                        break;
                    case 1:
                        $newpath = $path . 'partials/';
                        $newfile =  '_aside-list';
                        break;
                    case 2:
                        $newpath = $path . 'partials/';
                        $newfile = '_welcome';
                        break;
                    case 3:
                        $newpath = $path . 'partials/';
                        $newfile = '_article';
                        break;
                    case 4:
                        $newpath = $path . 'partials/';
                        $newfile = '_main-menu';
                        break;
                    case 5:
                        $newpath = $path . 'partials/';
                        $newfile = '_login-form';
                        break;
                    default:
                        $newpath = $path;
                        $newfile = $file;
                }


                $res = $this->makedirs($newpath);
                if($res) {
                    $res = $this->writeFile($newpath, $newfile, $ext, $this->data[$key]);
                }
            }
        } else {
            $res = $this->makedirs($path);
            if($res) {
                $res = $this->writeFile($path, $file, $ext, $this->data);
            }
        }
        return $res;
    }

    /**
     * writeFile Method: creates a file if does not exist
     * @param $path
     * @param $file
     * @param $ext
     * @param $data
     * @return bool on true returns the path of the newly created file.
     */
    private function writeFile($path, $file, $ext, $data)
    {
        if($fh = fopen($path.$file.$ext, "x+")){

            if(fwrite($fh, $data)){
                return $path;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function makedirs($dir, $mode = '0777', $recursive = true) {
        if (is_null($dir) || $dir === "") {
            return false;
        }
        if (is_dir($dir) || $dir === "/") {
            return true;
        }
        if ($this->makedirs(dirname($dir), $mode, $recursive)) {
            return mkdir($dir, $mode);
        }

        return false;
    }


}

new Make($argv);