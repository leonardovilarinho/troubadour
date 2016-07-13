<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 11/07/2016
 * Time: 19:58
 */
abstract class Alias
{
    /**
     * @var array - armazena os alias existentes
     */
    private static $alias = array();


    public static function set($controller, $method, $alias)
    {
        $link = mb_strtolower($controller.'/'.$method);
        self::$alias[$link] = $alias;
    }

    public static function check($alias)
    {
        $alias = mb_strtolower($alias);
        if(in_array($alias, self::$alias))
            return array_keys(self::$alias, $alias)[0];
        else
            return false;
    }

    public static function get($controller, $method)
    {
        $link = mb_strtolower($controller.'/'.$method);
        if(array_key_exists($link, self::$alias))
            return self::$alias[$link];
        else
            return false;
    }

}