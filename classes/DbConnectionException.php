<?php
/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 8/14/2015
 * Time: 1:57 PM
 */
class DbConnectionException extends Exception
{
    function DbConnectionException($str)
    {
        parent::__construct ($str);
    }
}
?>
