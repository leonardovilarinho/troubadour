<?php

/**
 * Class Session
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:21
 */

class Post
{
    /**
     * Mostra os posts ativos
     */
    public static function display()
    {
        var_dump($_POST);
    }


    /**
     * Destroi variaveis de post
     */
    public static function destroy()
    {
        foreach ($_POST as $key => $value)
            unset($_POST[$key]);
    }

    /**
     * Cria uma variavel de post com o tempo definido da classe
     * 
     * @param $key - nome do post
     * @param $value - valor do post
     */
    public static function set($key, $value)
    {
        $_POST[$key] = $value;
    }

    /**
     * Pega uma variavel de post, caso não exista retorna false
     *
     * @param $key - nome da variavel
     * @return bool mixed - false ou a variavel de post
     */
    public static function get($key)
    {
        return (isset($_POST[$key]) and !empty($_POST[$key])) ? $_POST[$key] : null;
    }

}