<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 15:58
 */
class ChapterController extends Controller
{

    public function createDeed()
    {
        $this->title(Language::get('chapter')['create'])->display();
    }

    public function createPosted()
    {
        $book = Post::get('book');
        try
        {
            $chapter = new Chapter(null, Post::get('title'), Post::get('pages'), $book);
        }
        catch (Exception $e)
        {
            Errors::display($e->getMessage(), $_SERVER['REQUEST_URI']);
            exit();
        }

        if($chapter->insert())
            $this->to('Book', 'details', $book);
        else
            Errors::display(Language::get('global')['error']."oioioi", $_SERVER['REQUEST_URI']);
    }

    public function deleteDeed()
    {
        $book = new Book($this->param(1));
        $book->get();
        if($book->getUser()->getId() == Session::get('user'))
        {
            $chapter = new Chapter();
            $c = CriteriaBuilder::create()
                ->tables('chapters')
                ->_and('chapters.id', '=', $this->param(0))
                ->_and('chapters.book', '=', $this->param(1));

            if($chapter->delete($c))
                $this->to('Book', 'details',  $this->param(1));
            else
                Errors::display(Language::get('global')['error']."2", $_SERVER['REQUEST_URI']);
        }
        else
            Errors::display(Language::get('global')['error']."1", $_SERVER['REQUEST_URI']);



    }

    public function editDeed()
    {
        $this->title(Language::get('chapter')['edit']);
        $chapter = new Chapter();

        $c = CriteriaBuilder::create()
            ->tables('chapters', 'users', 'books')
            ->_and('chapters.id', '=', $this->param(0))
            ->_and('users.id', '=', Session::get('user'))
            ->_and('chapters.book', '=', $this->param(1))
            ->_and('books.id', '=', 'chapters.book');

        if($chapter->get($c))
            $this->addVar('chapter', $chapter);
        else
        {
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
            exit();
        }
        $this->display();
    }

    public function editPosted()
    {
        $b = Post::get('book');
        try
        {
            $book = new Chapter(Post::get('id'), Post::get('title'), Post::get('pages'), $b);
        }
        catch (Exception $e)
        {
            Errors::display($e->getMessage(), $_SERVER['REQUEST_URI']);
            exit();
        }

        if($book->update())
            $this->to('Book', 'details', $b);
        else
            Errors::display(Language::get('global')['error'], $_SERVER['REQUEST_URI']);
    }

}