<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 16:30
 */
class Log
{
    private static $dir = 'logs/';

    public static function register($msg, $archive = 'mysql_errors')
    {
        if(Settings::get('logs'))
        {
            $date = date('Y-m-d H:i:s');
            if(file_exists(self::$dir . $archive))
            {
                $msg = "________________________________________________________\n" .
                    "___" . $date . " by " . $_SERVER['REMOTE_ADDR'] . "\n" .
                    $msg . "\n";
                file_put_contents(self::$dir . $archive, $msg, FILE_APPEND);
            }
            else
                Errors::display('Arquivo de log não existe');
        }
    }
}