<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 15:58
 */
use Respect\Validation\Validator as v;
class Chapter extends Database
{
    protected $id;
    protected $title;
    protected $pages;
    protected $book;

    /**
     * Chapter constructor.
     * @param $id
     * @param $title
     * @param $pages
     * @param $book
     */
    public function __construct($id = null, $title = null, $pages = null, $book = null)
    {
        parent::__construct('chapters');
        $this->setId($id);
        $this->setTitle($title);
        $this->setPages($pages);
        $this->setBook($book);
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @throws Exception
     */
    public function setId($id)
    {
        if(v::intVal()->validate($id) or v::nullType()->validate($id))
            $this->id = $id;
        else
            throw new Exception(Language::get('chapter')['errorId']);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @throws Exception
     */
    public function setTitle($title)
    {
        if(v::stringType()->length(3,100)->validate($title) or v::nullType()->validate($title))
            $this->title = $title;
        else
            throw new Exception(Language::get('chapter')['errorTitle']);
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     * @throws Exception
     */
    public function setPages($pages)
    {
        if(v::intVal()->min(1)->validate($pages) or v::nullType()->validate($pages))
            $this->pages = $pages;
        else
            throw new Exception(Language::get('chapter')['errorPages']);
    }

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param mixed $book
     * @throws Exception
     */
    public function setBook($book)
    {
        if(v::objectType()->instance('Book')->validate($book) or v::nullType()->validate($book))
            $this->book = $book;
        else if(v::intVal()->validate($book))
        {
            $this->book = new Book($book);
            $this->book->get();
        }
        else
            throw new Exception(Language::get('chapter')['errorBook']);
    }



}