<?php

namespace LegionLab\Troubadour\Collections;

/**
 * Control Session
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 26/08/2016
 * Time: 11:17
 */
abstract class Utils
{
    private static $utils = array();

    public static function display()
    {
        var_dump(self::$utils);
    }

    /**
     * Destroi variaveis de ultilidade
     */
    public static function destroy()
    {
        foreach (self::$utils as $key => $value) {
            unset(self::$utils[$key]);
        }
        session_destroy();
    }


    /**
     * Adiciona variaveis
     */
    public static function add()
    {
        foreach (func_get_args() as $value) {
            if(is_string($value)) {
                array_push(self::$utils, $value);
            }
        }
    }


    /**
     * Remove uma variavel da lista
     *
     * @param $value - valor a ser removido
     */
    public static function rm($value)
    {
        unset(self::$utils[array_search($value, self::$utils)]);
    }

    /**
     * Pega array com todos ultilitários usados.
     *
     * @return array - array de ultilidades registradas
     */
    public static function listAll()
    {
        return self::$utils;
    }

}
