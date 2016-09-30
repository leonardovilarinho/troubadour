<?php

namespace Controllers;

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 15:47
 */
use LegionLab\Troubadour\Control\Controller;
use LegionLab\Troubadour\Control\Errors;
use LegionLab\Troubadour\Collections\Session;

class ErrorController extends Controller
{
    public function failDeed()
    {
        Session::set("is_error_displaing", true);
        if($this->ajax())
            echo Errors::last();
        else
        {
            if(Errors::link())
                $this->attr('link', Errors::link());
            $this->title('Oopss...')
               ->attr('error', Errors::last())
                ->view("/", "error")
                ->display();
        }
        exit();

    }
}