<?php

class  Article{

    public function __construct() {
        Db::connect();
    }
    //ToDo Exception handling
   
        /**
     * auto generated method
     * @param $id
     * @return mixed
     */
    public function getOne($id) {
        $query = "SELECT id, title, summary, body, image, created_at, updated_at FROM articles WHERE id = ?";
        try {
            $stmt = Db::prepareAndExecute($query, $id, PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
        }catch (PDOstatementException $e){
            echo $e->getMessage();
        }
        return $row;

    }
    
    /**
     * auto generated method
     * @return mixed
     */
    public function getAll() {
         try {
            $query = 'SELECT id, title, summary, body, image, created_at, updated_at FROM articles';
            $stmt = Db::setFetchMode( $query, PDO::FETCH_ASSOC);
            $list = $stmt->fetchAll();
        }catch (PDOstatementException $e) {
            echo $e->getMessage();
        }
        return $list;
    }
}