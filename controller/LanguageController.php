<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 23:06
 */

class LanguageController extends Controller
{
    public function changeDeed()
    {
        if($this->param(0) == 1)
            Language::set('pt-br');
        else if($this->param(0) == 2)
            Language::set('en-us');
        else if($this->param(0) == 3)
            Language::set('es');
        else
        {
            Errors::display("Linguagem não encontrada");
            exit();
        }

        
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}