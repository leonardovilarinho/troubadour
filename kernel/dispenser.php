<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 09/07/2016
 * Time: 22:05
 */

$url = isset($_GET['url']) ? $_GET['url'] : '';
unset($_GET['url']);
if(!empty($url))
{
    $params = explode('/', $url);
    $_GET['controller'] = isset($params[0]) ? $params[0] : '';
    $alias = Alias::check($_GET['controller']);
    if($alias != false)
    {
        $_GET['controller'] = explode('/', $alias)[0];
        $_GET['method'] =  explode('/', $alias)[1];
    }
    else
    {
        $_GET['method'] = isset($params[1]) ? $params[1] : '';
        unset($params[1]);
    }

    unset($params[0]);
    $get = array();
    foreach ($params as $value)
        array_push($get, $value);
    $_GET['params'] = $get;
}