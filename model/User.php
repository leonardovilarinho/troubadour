<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 19:09
 */
use Respect\Validation\Validator as v;
class User extends Database
{
    protected $id;
    protected $username;
    protected $password;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $password
     */
    public function __construct($id = null, $username = null, $password = null)
    {
        parent::__construct('users');
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
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
            throw new Exception(Language::get('user')['errorId']);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @throws Exception
     */
    public function setUsername($username)
    {
        if(v::alnum()->length(8, 40)->validate($username) or v::nullType()->validate($username))
            $this->username = $username;
        else
            throw new Exception(Language::get('user')['errorUsername']);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        if(v::length(8, 15) or v::nullType()->validate($password))
            $this->password = $password;
        else
            throw new Exception(Language::get('user')['errorPassword']);
    }



}