<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 14:17
 */
abstract class Saved
{
    public static function create()
    {
        Session::set(md5('saved' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']), $_POST);
    }

    public static function set($array)
    {
        if(is_array($array))
         Session::set(md5('saved' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']), $array);
    }

    public static function get($key)
    {
        if(isset(Session::get(md5('saved' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']))[$key]))
            return Session::get(md5('saved' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']))[$key];
        else
            return '';
    }

    public static function destroy()
    {
        unset($_SESSION[md5('saved' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])]);
    }
}