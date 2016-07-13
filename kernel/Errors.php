<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 15:39
 */
abstract class Errors
{

    public static function display($msg, $link = null)
    {
        Errors::append($msg);
        if(!is_null($link))
            self::addLink($link);
        header("Location:" . DOMAIN . '/error');
    }

    public static function link()
    {
        return Session::get('link_error');
    }

    private static function addLink($link)
    {
        Session::set('link_error', $link);
    }

    public static function append($msg)
    {
        Session::set('msg_errors', Session::get('msg_errors') . '<br>' . $msg);
        Session::set('last_error', $msg);
    }

    public static function last()
    {
        return Session::get('last_error');
    }

    public static function all()
    {
        return Session::get('msg_errors');
    }
}