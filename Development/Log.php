<?php

namespace LegionLab\Troubadour\Development;

use LegionLab\Troubadour\Collections\Settings;
use LegionLab\Troubadour\Control\Errors;

/**
 * Control Log
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 16:30
 */

class Log
{
    /**
     * Atributos privados
     * @var string - diretório onde se armazenará arquivos de log
     */
    private static $dir = 'logs/';

    /**
     * Registra um novo log, o log padrao é mysql_errors, onde são salvos os erros do banco de dados
     * automaticamente é pego o horário do log, ip que o executou e adicionado no arquivo do log
     * com a mensagem passado por parametro.
     *
     * @param $msg - mensagem do log a ser salvo
     * @param string $archive - arquivo de log a ser adicionada a mensagem
     */
    public static function register($msg, $archive = 'mysql_errors')
    {
        if(Settings::get('logs')) {
            $date = date('Y-m-d H:i:s');
            if(file_exists(__DIR__."/../../../../".self::$dir . $archive)) {
                $msg = "________________________________________________________\n" .
                    "___" . $date . " by " . $_SERVER['REMOTE_ADDR'] . "\n" .
                    $msg . "\n";
                file_put_contents(__DIR__."/../../../../".self::$dir . $archive, $msg, FILE_APPEND);
            }
            else {
                Errors::display('Arquivo de log não existe');
            }
        }
    }
}
