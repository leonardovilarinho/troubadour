<?php

/**
 * Class View
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 04/07/2016
 * Time: 14:03
 */
abstract class View
{
    /**
     * Pega todos os links existentes no projeto.
     *
     * @return array|bool - false se não houver nenhum, um array com todos links encontrados
     */
    public static function getAllLinks()
    {
        if(is_dir("controller"))
        {
            $dirController = dir("controller") ;
            $result = array();
            $remove = array("getTitle");
            while(($classArchive = $dirController->read()) !== false)
            {
                if(!is_dir($classArchive))
                {
                    require_once "controller/{$classArchive}";
                    $class = str_replace(".php", "", $classArchive);
                    $methods = get_class_methods($class);
                    foreach ($methods as $key => $value)
                    {
                        $value = mb_strtolower(mb_substr($value, strlen($value) - 4)) == "deed" ? mb_substr($value, 0, -4) : $value;
                        $methods[$key] = $value;
                        $posted = mb_strtolower( mb_substr($value, strlen($value) -6)) == "posted";
                        $magic = mb_substr($value, 0, 2) == "__";
                        $rmv = in_array($value, $remove);
                        $unview = in_array($value, Settings::get("unview"));
                        if($posted or $magic or $rmv or $unview)
                            unset($methods[$key]);
                    }
                    $result[mb_strtolower(mb_substr($class, 0, -10))] = $methods;
                }

            }
            $dirController->close();
            return $result;
        }
        else
            return false;
    }

    /**
     * Pegar links que um determinado usuario pode acessar.
     *
     * @param $userId - identificador do usuario
     * @return array|bool - false se nao encontrar, se encontrar retorna um array com os links
     */
    public static function getLinkByUser($userId)
    {
        if(is_dir("controller"))
        {
            $dirController = dir("controller") ;
            $result = array();
            $remove = array("getTitle");
            while(($classArchive = $dirController->read()) !== false)
            {
                if(!is_dir($classArchive))
                {
                    require_once "controller/{$classArchive}";
                    $class = str_replace(".php", "", $classArchive);
                    $methods = get_class_methods($class);
                    foreach ($methods as $key => $value)
                    {
                        $posted = mb_strtolower( mb_substr($value, 0, -6)) == "posted";
                        $magic = mb_substr($value, 0, 2) == "__";
                        $rmv = in_array($value, $remove);
                        $unview = in_array($value, Settings::get("unview"));
                        if($posted or $magic or $rmv or $unview)
                            unset($methods[$key]);
                        else if(!Access::checkPrivate($userId, mb_strtolower(mb_substr($class, 0, -10)), mb_strtolower($value)))
                            unset($methods[$key]);
                    }
                    $result[mb_strtolower(mb_substr($class, 0, -10))] = $methods;
                }

            }
            $dirController->close();
            return $result;
        }
        else
            return false;
    }

    /**
     * Pegar todos os links configurados como publicos.
     *
     * @return array|bool - false se nao encontrar, se encontrar retorna um array com todos links encontrados
     */
    public static function getLinksPublics()
    {
        if(is_dir("controller"))
        {
            $dirController = dir("controller") ;
            $result = array();
            $remove = array("getTitle");
            while(($classArchive = $dirController->read()) !== false)
            {
                if(!is_dir($classArchive))
                {
                    require_once "controller/{$classArchive}";
                    $class = str_replace(".php", "", $classArchive);
                    $methods = get_class_methods($class);
                    foreach ($methods as $key => $value)
                    {
                        $posted = mb_strtolower( mb_substr($value, 0, -6)) == "posted";
                        $magic = mb_substr($value, 0, 2) == "__";
                        $rmv = in_array($value, $remove);
                        $unview = in_array($value, Settings::get("unview"));
                        if($posted or $magic or $rmv or $unview)
                            unset($methods[$key]);
                        else if(!Access::checkPublic(mb_strtolower(mb_substr($class, 0, -10)), mb_strtolower($value)))
                            unset($methods[$key]);
                    }
                    $result[mb_strtolower(mb_substr($class, 0, -10))] = $methods;
                }

            }
            $dirController->close();
            return $result;
        }
        else
            return false;
    }
}