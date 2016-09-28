<?php

namespace LegionLab\Troubadour\Persistence;

use LegionLab\Troubadour\Collections\Session;
use LegionLab\Troubadour\Collections\Settings;
use LegionLab\Troubadour\Development\Log;

/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 15/08/16
 * Time: 14:05
 */
abstract class Connect
{
    public static $conn = null;

    public static function tryConnect($line, $dbname = null)
    {
        try {
            if(is_null(self::$conn)) {
                if(!is_null($dbname))
                    $dbname =  ';dbname=' . $dbname;
                Session::set("teste", $dbname);
                self::$conn = new \PDO(
                    'mysql:host=' . Settings::get('dbhost') . $dbname,
                    Settings::get('dbuser'),
                    Settings::get('dbpassword'),
                    array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
                Log::register("Is connect \nIn l:".$line, "mysql_success");

                return self::$conn;
            }
            else {
                return self::$conn;
            }
        } catch (\Exception $e) {
            Log::register($e->getMessage()."In l:" .__LINE__);
            return false;
        }
    }


}
