<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 20:17
 */
class BookController extends Controller
{
    public function detailsDeed()
    {
        if($this->param(0))
        {
            $this->addVar('book', $this->param(0))->title(Language::get('book')['details']);

            $ch = new Chapter();
            $c = CriteriaBuilder::create()
                ->tables('chapters', 'books')
                ->displays('chapters.*')
                ->_and('chapters.book', '=', $this->param(0))
                ->_and('books.user', '=', Session::get('user'))
                ->_and('chapters.book', '=', 'books.id');

            $this->addVar('chapters', $ch->listAll(new Pager(5, $ch->count($c)), $c))->display();
        }
        else
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
    }

    public function listDeed()
    {
        $this->title(Language::get('book')['list']);
        $b = new Book();
        $c = CriteriaBuilder::create()
            ->tables('books')
            ->_and('user', '=', Session::get('user'));

        $p = new Pager(5, $b->count($c));
        $this->addVar('books', $b->listAll($p, $c))->display();
    }

    public function createDeed()
    {
        $this->title(Language::get('book')['create'])->display();
    }
    
    public function createPosted()
    {
        try
        {
            $book = new Book(null, Post::get('name'), Post::get('author'), Post::get('price'), Session::get('user'));
        }
        catch (Exception $e)
        {
            Errors::display($e->getMessage(), $_SERVER['REQUEST_URI']);
            exit();
        }

        if($book->insert())
            $this->to('Book', 'list');
        else
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
    }

    public function deleteDeed()
    {
        $book = new Book();

        $c = CriteriaBuilder::create()
            ->tables('books')
            ->_and('id', '=', $this->param(0))
            ->_and('user', '=', Session::get('user'));

        if($book->delete($c))
            $this->to('Book', 'list');
        else
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
    }

    public function editDeed()
    {
        $this->title(Language::get('book')['edit']);
        $book = new Book();

        $c = CriteriaBuilder::create()
            ->tables('books')
            ->_and('id', '=', $this->param(0))
            ->_and('user', '=', Session::get('user'));

        if($book->get($c))
            $this->addVar('book', $book);
        else
        {
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
            exit();
        }
        $this->display();
    }

    public function editPosted()
    {
        try
        {
            $book = new Book(Post::get('id'), Post::get('name'), Post::get('author'), Post::get('price'), Session::get('user'));
        }
        catch (Exception $e)
        {
            Errors::display($e->getMessage(), $_SERVER['REQUEST_URI']);
            exit();
        }

        if($book->update())
            $this->to('Book', 'list');
        else
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
    }
}