<?php

namespace LegionLab\Troubadour\Control;

use LegionLab\Troubadour\Collections\Settings;
use LegionLab\Troubadour\Collections\Session;

/**
 * Control Errors
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 15:39
 */
abstract class Errors
{

    /**
     * Adiciona mensagem de erro no historico e chama o controlador de erro para exibir a tela.
     *
     * @param $msg - mensagem de erro a ser exibida
     * @param null $link - link de botão para voltar
     */
    public static function display($msg, $link = null)
    {
        if(!Settings::get('ignoreErrors') ) {
            Errors::append($msg);
            if(!is_null($link)) {
                self::addLink($link);
            }

            header("Location:" . DOMAIN . '/error');
        }
    }

    /**
     * Resgata o link do erro atual.
     *
     * @return mixed - string com o link se encontrar ou false
     */
    public static function link()
    {
        return Session::get('link_error');
    }

    /**
     * Seta um novo link para o erro atual.
     *
     * @param $link - string contendo o link do botao da tela de erro
     */
    private static function addLink($link)
    {
        Session::set('link_error', $link);
    }

    /**
     * Acrescenta a mensagem recebida no historico de erros e define como ultima
     * mensagem de erro.
     *
     * @param $msg - string com mensagem de erro
     */
    public static function append($msg)
    {
        Session::set('msg_errors', Session::get('msg_errors') . '<br>' . $msg);
        Session::set('last_error', $msg);
    }

    /**
     * Pega ultima mensagem de erro registrada.
     *
     * @return mixed - string com a mensagem encontrada ou false
     */
    public static function last()
    {
        return Session::get('last_error');
    }

    /**
     * Resgata todas mensagens de erro do historico em uma string html.
     *
     * @return mixed - string com as mensagem encontradas ou false
     */
    public static function all()
    {
        return Session::get('msg_errors');
    }
}
