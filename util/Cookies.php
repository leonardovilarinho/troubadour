<?php

/**
 * Class Session
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:21
 */

class Cookies
{
    /**
     * @var null - tempo padrao de cookie
     */
    private static $time = null;

    /**
     * Mostra os cookies ativos
     */
    public static function display()
    {
        var_dump($_COOKIE);
    }

    /**
     * Define o periodo de tempo que um cookie é ativo
     * @param $t - tempo de cookie
     */
    public static function time($t)
    {
        self::$time = $t;
    }
    /**
     * Destroi variaveis de cookie
     */
    public static function destroy()
    {
        foreach ($_COOKIE as $key => $value)
            unset($_COOKIE[$key]);
    }

    /**
     * Cria uma variavel de cookie com o tempo definido da classe
     * 
     * @param $key - nome do cookie
     * @param $value - valor do cookie
     */
    public static function set($key, $value)
    {
        if(is_null(self::$time))
            setcookie($key, $value);
        else
            setcookie($key, self::$time);
    }

    /**
     * Pega uma variavel de cookie, caso não exista retorna false
     *
     * @param $key - nome da variavel
     * @return bool mixed - false ou a variavel de cookie
     */
    public static function get($key)
    {
        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : false;
    }

}