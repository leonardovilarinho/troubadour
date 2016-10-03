<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 25/07/2016
 * Time: 12:48
 */
namespace Controllers;

use LegionLab\Troubadour\Control\Controller;
use LegionLab\Utils\Language;
use Models\Home;

class HomeController extends Controller
{
    public function pageDeed()
    {
        $home = new Home();
        $home->hello( Language::get('home', 'hello') );
        $this
            ->title( 'Troubadour PHP Framework' )
	        ->attr( 'hello', $home->hello() )
            ->view( '/', 'page' )
            ->display();
    }
}
