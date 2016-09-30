<?php

namespace Models;

//use LegionLab\Troubadour\Persistence\Database;
use Respect\Validation\Validator as v;
use LegionLab\Utils\Language;

class Home //extends Database
{
    protected $hello;

    /**
     * Home constructor.
     * @param $hello
     */
    public function __construct($hello = null)
    {
        //parent::__construct('article');
        $this
            ->hello($hello);
    }

    /**
     * @param string $hello
     * @return mixed
     * @throws \Exception
     */
    public function hello($hello = '@')
    {
        if($hello !== '@') {
            if(v::stringType()->length(3, 100)->validate($hello) or v::nullType()->validate($hello))
                $this->hello = $hello;
            else
                throw new \Exception(Language::get('home', 'e-hello'));
            return $this;
        } else {
            return $this->hello;
        }

    }
}
