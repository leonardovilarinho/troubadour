<?php

namespace LegionLab\Troubadour\Development;

use LegionLab\Troubadour\Collections\Settings;

/**
 * Control Security
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 08/07/2016
 * Time: 13:37
 */
abstract class Security
{
    /**
     * Desliga ou liga a exibição de mensagens de erro de acordo com a variavel de configuração que
     * indica se solução está ou não em desenvolvimento.
     */
    public static function errors()
    {
        if(Settings::get('deployment') === true) {
            ini_set('display_errors', 'On');
            ini_set('display_startup_errors ', 'On');
            ini_set('error_reporting', -1);
            ini_set('log_errors', 'On');

        }
        else {
            ini_set('display_errors', 'Off');
            ini_set('display_startup_errors ', 'Off');
            ini_set('error_reporting', E_ALL);
            ini_set('log_errors', 'On');
        }
    }


}
