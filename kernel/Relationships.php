<?php

/**
 * Class Relationships
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:41
 */

abstract class Relationships
{
    /**
     * @var array - armazena o content de relacionamento
     */
    private static $rel = array();

    /**
     * Cria um novo relacionamento entre objetos, $objeto depende de ou tem um ou mais $link para funcionar.
     *
     * @param $object - objeto pai
     * @param $links - objeto que se torna atributo do pai (pode ser um array de dependecias)
     */
    public static function set($object, $links)
    {
        $object = mb_strtolower($object);
        self::$rel[$object] = $links;
    }

    /**
     * Verifica se um objeto ja tem a relacao com outro registrada.
     *
     * @param $object - objeto pai
     * @param $link - objeto que se torna atributo do pai
     * @return bool - true para sim e false para nao
     */
    public static function check($object, $link)
    {
        $object = mb_strtolower($object);
        if(array_key_exists($object, self::$rel))
        {
            if(is_array(self::$rel[$object]))
            {
                if(array_key_exists($link, self::$rel[$object]))
                    return true;
            }
            else if(self::$rel[$object] === $link)
                return true;
        }
        return false;

    }

    /**
     * Pega as dependencias de um objeto.
     * @param $object - objeto pai
     * @return bool|mixed - false para nenhuma dependencia, ou o nome da dependencia
     */
    public static function get($object)
    {
        $object = mb_strtolower($object);
        if(array_key_exists($object, self::$rel))
            return self::$rel[$object];
        else
            return false;
    }

}