<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 20:17
 */
use Respect\Validation\Validator as v;
class Book extends Database
{
    protected $id;
    protected $name;
    protected $author;
    protected $price;
    protected $user;

    /**
     * Book constructor.
     * @param $id
     * @param $name
     * @param $author
     * @param $price
     * @param $user
     */
    public function __construct($id = null, $name = null, $author = null, $price = null, $user = null)
    {
        parent::__construct('books');
        $this->setId($id);
        $this->setName($name);
        $this->setAuthor($author);
        $this->setPrice($price);
        $this->setUser($user);
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
            throw new Exception(Language::get('book')['errorId']);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @throws Exception
     */
    public function setName($name)
    {
        if(v::stringType()->length(3, 100)->validate($name) or v::nullType()->validate($name))
            $this->name = $name;
        else
            throw new Exception(Language::get('book')['errorName'] . $name);

    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @throws Exception
     */
    public function setAuthor($author)
    {
        if(v::stringType()->length(3, 50)->validate($author) or v::nullType()->validate($author))
            $this->author = $author;
        else
            throw new Exception(Language::get('book')['errorAuthor']);
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @throws Exception
     */
    public function setPrice($price)
    {
        if(v::floatVal()->validate($price) or v::nullType()->validate($price))
            $this->price = $price;
        else
            throw new Exception(Language::get('book')['errorPrice']);

    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @throws Exception
     */
    public function setUser($user)
    {
        if(v::objectType()->instance('User')->validate($user) or v::nullType()->validate($user))
            $this->user = $user;
        else if(v::intVal()->validate($user))
        {
            $this->user = new User($user);
            $this->user->get();
        }
        else
            throw new Exception(Language::get('book')['errorUser']);
    }



}