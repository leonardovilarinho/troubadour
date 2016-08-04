<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 04/07/2016
 * Time: 16:59
 */

class UserController extends Controller
{
    public function loginDeed()
    {
        if(!Session::get('user'))
        {
            $this->noTemplate();
            $this->view("/", "login");
            $this->display();
        }
        else
            $this->to('book', 'list');
    }

    public function logoutDeed()
    {
        if(Session::get('user'))
            Session::destroy();
        $this->to('User', 'login');

    }

    public function loginPosted()
    {
        try
        {
            $user = new User(null, Post::get('username'));
        }
        catch (Exception $e)
        {
            $this->addVar('error', $e->getMessage());
            $this->noTemplate();
            $this->view("/", "login");
            $this->display();
            exit();
        }
        $c = new Criteria();
        $c->tables('users');
        $c->_and('username', '=', $user->getUsername());

        $user->get($c);

        if(password_verify(Post::get('password'), $user->getPassword()))
        {
            Session::set('area', 1);
            Session::set('user', $user->getId());
            Session::set('username', $user->getUsername());
            $this->to('book', 'list');
        }
        else
        {
            $this->addVar('error', Language::get('login')['error']);
        }
        $this->noTemplate();
        $this->view("/", "login");
        $this->display();
    }

    public function registerDeed()
    {
        $this->noTemplate();
        $this->view("/", "register");
        $this->display();
    }

    public function registerPosted()
    {
        try
        {
            Post::set('password', password_hash(Post::get('password'), PASSWORD_DEFAULT));
            $user = new User(null, Post::get('username'), Post::get('password'));
        }
        catch (Exception $e)
        {
            $this->addVar('error', $e->getMessage());
            $this->noTemplate();
            $this->view("/", "register");
            $this->display();
            exit();
        }
        $c = new Criteria();
        $c->tables('users');
        $c->_and('username', '=', $user->getUsername());

        if($user->count($c) > 0)
        {
            $this->addVar('error', Language::get('register')['exists']);
            $this->noTemplate();
            $this->view("/", "register");
            $this->display();
        }
        else
        {
            if($user->insert())
                $this->to('user', 'login');
            else
            {
                $this->addVar('error', Language::get('global')['error']);
                $this->noTemplate();
                $this->view("/", "register");
                $this->display();
            }
        }


    }

}