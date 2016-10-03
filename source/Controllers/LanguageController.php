<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 23:06
 */

namespace Controllers;

use LegionLab\Troubadour\Control\Controller;
use LegionLab\Troubadour\Control\Errors;
use LegionLab\Utils\Language;

class LanguageController extends Controller
{
    public function changeDeed()
    {
        $this->param(0, function($success) {
            if($success == 1)
                Language::set('pt');
            else if($success == 2)
                Language::set('en');
            else {
                Errors::display("Linguagem não encontrada");
                exit();
            }
        });

       header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}
