<?php

/**
 * Created by PhpStorm.
 * User: EASJ
 * Date: 14-05-2017
 * Time: 20:39
 */
class PDOstatementException extends PDOException
{
    public function __construct($message = 'An Error occurred', $code = 0, $previous = null) {

        if(ZEMA_ENVIRONMENT === 'production') {
            $message = PDO_STATEMENT_EXCEPTION_MESSAGE;
        }
        return parent::__construct('<pre>'.$message.'</pre>', $code, $previous);
    }
}