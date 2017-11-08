<?php

/**
 * Created by PhpStorm.
 * User: EASJ
 * Date: 15-05-2017
 * Time: 16:37
 */
class ResourceNotFoundException extends BadMethodCallException
{
    public function __construct($message = 'Resource  not found', $code = 0, $previous = null) {

        if(ZEMA_ENVIRONMENT === 'production') {
            $message = '<strong style="color: red;">An unexpected error  occurred. </strong><br>';
            $message .= 'If it continues please contact the site Administrator';
        }
        return parent::__construct('<pre>'.$message.'</pre>', $code, $previous);
    }
}