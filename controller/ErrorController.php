<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 15:47
 */
class ErrorController extends Controller
{
    public function failDeed()
    {
        exit();
        echo "oi";
        if(Errors::link())
            $this->addVar('link', Errors::link());
        $this->error('Ooopss..', Errors::last());
    }
}