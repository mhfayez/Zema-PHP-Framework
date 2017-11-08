<?php
/**
 * Created by Mohammad Homayoon Fayez.
 * Date: 01-05-2017
 * Time: 16:44
 */
class Db {
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    protected static $dbh;

    /**
     * Create a *Singleton* instance of this PDO.
     *
     * @return void The *Singleton* instance.
     */
    public static function connect()
    {
        if (null === static::$dbh) {
            try{
                static::$dbh = new PDO(DB_DSN,USERNAME,PASSWORD);
                static::$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                static::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e) {
                echo $e->getMessage();
                die();
            }
        }
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton*
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * Public setFetchMode method: sets the PDO fetch $mode for the $query
     * @param $query
     * @param $mode
     * @return mixed
     */
    public static function setFetchMode($query, $mode) {
        try {
            $stmt = self::$dbh->query($query);
            $stmt->setFetchMode($mode);
        }catch (Exception $e) {
            throw new PDOstatementException($e);
        }

        return $stmt;
    }


    //ToDo: Fix Me: Uncaught TypeError: Argument 3 passed to Db::prepareAndExecute() must be of the type array, null given

    /**
     * @param $query
     * @param array $data
     * @param $mode
     * @return mixed *PDO* statement
     */
    public static function prepareAndExecute($query, array $data, $mode)
    {
       try {
           $stmt = self::$dbh->prepare($query);
           if(!empty($mode)) {
               $stmt->setFetchMode($mode);
           }
           $stmt->execute($data);
       }catch (Exception $e) {
               throw new PDOstatementException($e);
           }
        return $stmt;
    }


    public static function handler()
    {
        return self::$dbh;
    }
}