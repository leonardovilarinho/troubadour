<?php

namespace LegionLab\Troubadour\Routes;

/**
 * Control Access
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:24
 */

abstract class Access
{
    /**
     * @var array - lista de links publicos e lista de links privados.
     */
    private static $public = array();
    private static $private = array();

    /**
     * Adiciona um acesso privado para ser reconhecido, indicando o usuário desse acesso,
     * o controlador e os metodos que podem ser acessados.
     *
     * @param $user - usuário que pode acessa-lo
     * @param $controller - indica clase controladora
     * @param array $methods - arrays com nomes de metodos
     */
    public static function setPrivate($user, $controller, $methods = array())
    {
        $user = mb_strtolower($user);
        $controller = mb_strtolower($controller);
        if(is_array($methods))
            foreach ($methods as $key => $value)
                $methods[$key] = mb_strtolower($value);
        else
            $methods = mb_strtolower($methods);
        self::$private[$user][$controller] = $methods;
    }

    /**
     * Adiciona um acesso publico para o reconhecimento, acessos publicos sao aquele que
     * usuario não logados tembém podem visualizar e interagir.
     *
     * @param $controller - indica clase controladora
     * @param array $methods - array com nome de metodos
     */
    public static function setPublic($controller, $methods = array())
    {
        $controller = mb_strtolower($controller);
        if(is_array($methods))
            foreach ($methods as $key => $value)
                $methods[$key] = mb_strtolower($value);
        else
            $methods = mb_strtolower($methods);
        self::$public[$controller] = $methods;
    }

    /**
     * Checa se um acesso privado existe, quando lhe passado usuario, controller e metodo.
     *
     * @param $user - usuario do acesso
     * @param $controller - controlador requisitado
     * @param $method - metodo requisitado
     * @return bool - true para liberado e false para negado
     */
    public static function checkPrivate($user, $controller, $method)
    {
        $controller = mb_strtolower($controller);
        $method = mb_strtolower($method);
        if(array_key_exists($user, self::$private)) {
            if(is_array(self::$private[$user])) {
                if(array_key_exists($controller, self::$private[$user])) {
                    if(is_array(self::$private[$user][$controller])) {
                        if(in_array($method, self::$private[$user][$controller]) or in_array('*', self::$private[$user][$controller]))
                            return true;
                    }
                    else if(self::$private[$user][$controller] === $method or self::$private[$user][$controller] === '*')
                        return true;
                }
                else if(array_key_exists('*', self::$private[$user])) {
                    if(is_array(self::$private[$user]['*'])) {
                        if(in_array($method, self::$private[$user]['*']) or self::$private[$user]['*'][0] === '*')
                            return true;
                    }
                    else {
                        if(self::$private[$user]['*'] === '*')
                            return true;
                    }

                }
            }
            else if(self::$private[$user] === $method or self::$private[$user] === '*')
                return true;
        }


        return false;
    }

    /**
     * Checa se um acesso publico foi configurado, recebendo o controller e metodo.
     *
     * @param $controller - controlador a ser verificado
     * @param $method - metodo a verificar
     * @return bool - true para liberado e false para negado
     */
    public static function checkPublic($controller, $method)
    {
        $controller = mb_strtolower($controller);
        $method = mb_strtolower($method);
        if(array_key_exists($controller, self::$public)) {
            if(is_array(self::$public[$controller])) {
                if(in_array($method, self::$public[$controller]) or in_array('*', self::$public[$controller]))
                    return true;
            }
            else if(self::$public[$controller] === $method or self::$public[$controller] === '*')
                return true;
        }
        else if(array_key_exists('*', self::$public)) {
            if(is_array(self::$public['*'])) {
                if(in_array($method, self::$public['*']) or self::$public['*'][0] === '*')
                    return true;
            }
            else {
                if(self::$public['*'] === '*')
                    return true;
            }

        }

        return false;
    }

}
