<?php

namespace LegionLab\Troubadour\Routes;

/**
 * Control Alias
 *
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


    /**
     * Cria um novo Alias (atalho, ou sinonimo) para uma rota.
     *
     * @param $controller - controlador a ser chamado
     * @param $method - metodo do controlador a ser executado
     * @param $alias - atalho para URL
     */
    public static function set($controller, $method, $alias)
    {
        $link = mb_strtolower($controller.'/'.$method);
        self::$alias[$link] = $alias;
    }

    /**
     * Verifica se um alias existe, se sim retorna controlador/metodo para que ele possa ser traduzido, se
     * não retorna false.
     *
     * @param $alias - nome do atalho
     * @return mixed - link da rota ou false
     */
    public static function check($alias)
    {
        $alias = mb_strtolower($alias);
        if(in_array($alias, self::$alias))
            return array_keys(self::$alias, $alias)[0];
        else
            return false;
    }

    /**
     * Pega um alias quando passado um controlador e um metodo.
     *
     * @param $controller - controlador do alias
     * @param $method - metodo do alias
     * @return bool|mixed - string com nome do alias ou false
     */
    public static function get($controller, $method)
    {
        $link = mb_strtolower($controller.'/'.$method);
        if(array_key_exists($link, self::$alias))
            return self::$alias[$link];
        else
            return false;
    }

}
