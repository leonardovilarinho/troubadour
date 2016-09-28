<?php

namespace LegionLab\Troubadour\Collections;

/**
 * Control Session
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:21
 */
abstract class Session
{
    public static function display()
    {
        var_dump($_SESSION);
    }
    /**
     * Cria uma nova sessao
     */
    public static function create()
    {
        ini_set('session.cookie_httponly', 1);
        session_start();
        if(!Session::get('login')) {
            Session::set('login', md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
        }

        session_name(md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
    }

    public static function check()
    {
        return Session::get('login') === md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Destroi variaveis de sessao e a sessao criada
     */
    public static function destroy()
    {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }

        session_destroy();
    }

    /**
     * Cria uma variavel de sessao
     *
     * @param $key - nome da variavel
     * @param $value - valor da variavel
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Pega uma variavel de sessao, caso não exista retorna false
     *
     * @param $key - nome da variavel
     * @return bool mixed - false ou a variavel de sessao
     */
    public static function get($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

}
