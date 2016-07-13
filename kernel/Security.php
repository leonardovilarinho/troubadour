<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 08/07/2016
 * Time: 13:37
 */
abstract class Security
{
    public static function errors()
    {
        if(Settings::get('deployment') === true)
        {
            ini_set('display_errors', 'On');
            ini_set('display_startup_errors ', 'On');
            ini_set('error_reporting', -1);
            ini_set('log_errors', 'On');

        }
        else
        {
            ini_set('display_errors', 'Off');
            ini_set('display_startup_errors ', 'Off');
            ini_set('error_reporting', E_ALL);
            ini_set('log_errors', 'On');
        }
    }

    public static function validateToken($token)
    {
        return Session::get('token') === $token;
    }

}