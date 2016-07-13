<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 08/07/2016
 * Time: 11:18
 */
class ValidatePost
{

    public static function mask($var, $separator, $arrayOfLenghts, $numeric = true)
    {
        if($numeric)
            $expression = "0-9";
        else
            $expression = "a-zA-Z";

        $regex = "";
        foreach ($arrayOfLenghts as $value)
            if(is_numeric($value))
                $regex .= "[{$expression}]{{$value}}" . $separator;

        if (preg_match("^{$regex}$", $var))
            return true;
        else
            return false;
    }

    public static function int($name, $min = null, $max = null, $required = true, $sanitize = false)
    {
        if($sanitize)
            $_POST[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_INT);

        if(filter_var($_POST[$name], FILTER_VALIDATE_INT))
            return self::interval($max, $min, $name);
        else
        {
            $_POST[$name] = null;
            return !$required;
        }

    }

    public static function float($name, $min = null, $max = null, $required = true, $sanitize = false)
    {
        if($sanitize)
            $_POST[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_FLOAT);
        
        if(filter_var($_POST[$name], FILTER_VALIDATE_FLOAT))
            return self::interval($max, $min, $name);
        else
        {
            $_POST[$name] = null;
            return !$required;
        }
    }

    public static function string($name, $min = null, $max = null, $required = true)
    {
        $_POST[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING);
        if($required)
            return self::intervalString($max, $min, $name);
        else
        {
            if(!empty($_POST[$name]))
                return self::intervalString($max, $min, $name);
            else
                return true;
        }
    }

    public static function email($name, $min = null, $max = null, $required = true, $sanitize = false)
    {
        if($sanitize)
            $_POST[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_EMAIL);

        if(filter_var($_POST[$name], FILTER_VALIDATE_EMAIL))
            return self::intervalString($max, $min, $name);
        else
        {
            $_POST[$name] = null;
            return !$required;
        }
    }

    public static function url($name, $min = null, $max = null, $required = true, $sanitize = false)
    {
        if($sanitize)
            $_POST[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_URL);

        if(filter_var($_POST[$name], FILTER_VALIDATE_URL))
            return self::intervalString($max, $min, $name);
        else
        {
            $_POST[$name] = null;
            return !$required;
        }
    }

    public static function ip($name)
    {
        if(filter_var($_POST[$name], FILTER_VALIDATE_IP))
                return true;
        return false;
    }

    public static function mac($name)
    {
        if(filter_var($_POST[$name], FILTER_VALIDATE_MAC))
            return true;
        return false;
    }
    private static function interval($max, $min, $name)
    {
        if(!is_null($min))
        {
            if(!is_null($max))
                return ($_POST[$name] >= $min and $_POST[$name] <= $max);
            else
                return ($_POST[$name] >= $min);
        }
        else
        {
            if(!is_null($max))
                return ($_POST[$name] <= $max);
            else
                return true;
        }
    }

    private static function intervalString($max, $min, $name)
    {
        if(!is_null($min))
        {
            if(!is_null($max))
                return (mb_strlen($_POST[$name]) >= $min and mb_strlen($_POST[$name]) <= $max);
            else
                return (mb_strlen($_POST[$name]) >= $min);
        }
        else
        {
            if(!is_null($max))
                return (mb_strlen($_POST[$name]) <= $max);
            else
                return true;
        }
    }

}