<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 09/07/2016
 * Time: 22:05
 */

use LegionLab\Troubadour\Routes\Alias;

/**
 * Resgata parametros da URL, separa controller de method, verificando também se o link
 * representa um alias, se representar pega o controlador e metodo do alias, se não pega
 * o padrao do link (site.com/controlador/metodo/parametros). Por fim resgata os demais parametros
 * colocando-o em array para serem usados no controlador.
 *
 * Exemplo:
 * URL -> site.com/pessoas/editar/51
 * Resultado do script será:
 *      $_GET['controller'] = 'pessoas'
 *      $_GET['method'] = 'editar'
 *      $_GET['params'] = array(0 => 51)
 *
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

    if(count($_GET) > 2)
    {
        foreach ($_GET as $key => $value)
        {
            if($key != "controller" and $key != "method")
            {
                array_push($get, $value);
                unset($_GET[$key]);
            }
        }
    }


    $_GET['params'] = $get;
}
