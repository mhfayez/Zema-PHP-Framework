<?php

/**
 * Author: Mohammad Homayoon Fayez
 * Date: 01-05-2017
 * Time: 15:50
 * Scaffold
 *
 */
class Scaffold
{
    public $stmt;
    public $dbc;
    public $fileName;
    public $tableName;
    public $columnNames;
    public $tableColumns;
    public $controllerName;
    public $viewName;
    public $objectType;
    public $attributes;
    public static $getAllMethod;
    public static $getOneMethod;
    public static $getIndexMethod;
    public static $getArticleMethod;
    public static $getTitlesMethod;
    private $flag;

    public function __construct($type, $name, $flag)
    {
        if($flag) {
            $this->fileName = 'Article';
            $this->tableName = $name;
        } else {
            $this->tableName = $this->fileName = $this->controllerName =  $name;
        }

        if($type === "model") {
            $this->tableColumns = $this->getColumnNames();
            if (!empty($this->columnNames)) {
                $this->attributes = $this->makeAttributes($this->tableColumns);
                self::$getOneMethod = $this->addGetOneMethod($this->tableName, $this->tableColumns);
                self::$getAllMethod = $this->addGetAllMethod($this->tableName, $this->tableColumns);
            } else {
                exit("Error: Table [$this->tableName] does not exist in the database");
            }
        }elseif($type === "controller") {
            self::$getIndexMethod = $this->addIndexMethod();
            self::$getArticleMethod = $this->addGetArticleMethod();
            self::$getTitlesMethod = $this->addGetTitlesMethod();
        }

        $this->flag = $flag;
    }

    public function make(zemaMakeInterface $maker)
    {
        return $maker->make($this);
    }

    function getColumnNames()
    {
        $sql = 'SHOW COLUMNS FROM ' . $this->tableName;

    //    $this->stmt = $this->dbc->prepare($sql);

        try {
           // if ($this->stmt->execute()) {
                $this->stmt = Db::setFetchMode($sql, PDO::FETCH_ASSOC);
                $raw_column_data = $this->stmt->fetchAll();

                foreach ($raw_column_data as $outer_key => $array) {
                    foreach ($array as $inner_key => $value) {

                        if ($inner_key === 'Field') {
                            if (!(int)$inner_key) {
                                $this->columnNames[] = $value;
                            }
                        }
                    }
                }
         //   }
            return $this->columnNames;
        } catch (Exception $e) {
            return $e->getMessage(); //return exception
        }
    }

    function makeAttributes($tableColumns){
        $string = '';

        foreach($tableColumns as $column){

            $string .= "	var \$".$column.";\n";
        }

        return $string;
    }


    private function addGetAllMethod($tableName, $tableColumns){
        //Create the column Names
        $columnNames = $this->createColumnNames($tableColumns);

        $method = <<<METHOD
/**
     * auto generated method
     * @return mixed
     */
    public function getAll() {
         try {
            \$query = 'SELECT $columnNames FROM $tableName';
            \$stmt = Db::setFetchMode( \$query, PDO::FETCH_ASSOC);
            \$list = \$stmt->fetchAll();
        }catch (PDOstatementException \$e) {
            echo \$e->getMessage();
        }
        return \$list;
    }
METHOD;

        return $method;
    }

 private function addGetOneMethod($tableName, $tableColumns){
        //Create the column Names
     $columnNames = $this->createColumnNames($tableColumns);

     $method = <<<METHOD
    /**
     * auto generated method
     * @param \$id
     * @return mixed
     */
    public function getOne(\$id) {
        \$query = "SELECT $columnNames FROM $tableName WHERE $tableColumns[0] = ?";
        try {
            \$stmt = Db::prepareAndExecute(\$query, \$id, PDO::FETCH_ASSOC);
            \$row = \$stmt->fetch();
        }catch (PDOstatementException \$e){
            echo \$e->getMessage();
        }
        return \$row;

    }
METHOD;

        return $method;
    }

    private function addIndexMethod(){

        $method = <<<METHOD
    /**
     * auto generated method
     * @return void
     */
    public function index()
    {
        \$this->partial('_welcome');
        exit(\$this->create());
    }
METHOD;
        return $method;
    }
    
    
  private function addGetArticleMethod(){

        $method = <<<METHOD
    /**
     * Gets article  by id
     * Then sets the title, body and image tags
     * @param \$id
     */
    public function getArticle(\$id)
    {
        \$this->partial('_article');
        \$article = \$this->articleModel->getOne(\$id);
        \$this->setTag(TAGS['article_title'],\$article['title']);
        // concerned with security? then either htmlspecialchars it on saving or 
        //on displaying or allow only specific tags if you trust the users
        \$this->setTag(TAGS['article'],\$article['body']);
        //\$this->setArticle(htmlspecialchars(\$article['body']));
        \$this->setTag(TAGS['article_image'],\$article['image']);

        exit(\$this->create());
    }
METHOD;
        return $method;
    }
    
private function addGetTitlesMethod(){
    
    $method = <<<METHOD
     /**
     *Method articles gets all the articles titles
     */
    public function getTitles()
    {
        //the list is already generated in the controller
        //so just hide the unused partials and call create() method to create the view
        //\$this->hide([TAGS['article_title'], TAGS['article']]);
        //if you want to show some default text then you can do the following
        \$this->partial('_article');
        \$this->setTag(TAGS['article_title'],'');
        \$this->setTag(TAGS['article_image'],'paghman.jpg');
        \$this->setTag(TAGS['article'],'Find the articles of your interest. ');
        exit(\$this->create());
    }
METHOD;
        return $method;
    }
    
    

    private function createColumnNames($tableColumns){
        //Create the column Names
        $columnNames = '';
        foreach($tableColumns as $column){
            $columnNames .= "".$column.", ";
        }
        return rtrim($columnNames, ", ");

    }

}
