<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 22:02
 */
class Language
{
    private static $dir = 'languages/';

    public static function current()
    {
        return Session::get('current_lang');
    }

    public static function init()
    {
       if(Session::get('current_lang') === false)
           Session::set('current_lang', mb_strtolower(explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"])[0]));
    }

    public static function get($index, $section = true)
    {
        $archive = parse_ini_file(self::$dir .  Session::get('current_lang'). Settings::get('langExtension'), $section);
        if(key_exists($index, $archive))
            return $archive[$index];
        return false;
    }

    public static function set($lang)
    {
        Session::set('current_lang', in_array($lang, self::all()) ? $lang : null);
    }

    public static function all()
    {
        if(is_dir(self::$dir))
        {
            $directory = dir(self::$dir);
            $archives = array();
            while(($archive = $directory->read()) !== false)
                if(file_exists(self::$dir . $archive) and !is_dir(self::$dir . $archive))
                    array_push($archives, str_replace(Settings::get('langExtension'), "", $archive));

            $directory->close();
            return $archives;
        }
        return false;
    }
}