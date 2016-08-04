<?php

/**
 * Class Pager
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 05/07/2016
 * Time: 10:55
 */
class Pager
{
    /**
     * @var int - numero de item por pagina, quantas paginas e o maximo de item que foi encontrado.
     */
    private $onePage = 5;
    private $page = 1;
    private $maximum = 0;

    /**
     * Pager constructor.
     * @param int $onePage - numero de item por pagina
     * @param int $maximum - maximo de item que foi encontrado
     */
    public function __construct($onePage = 5, $maximum = 0)
    {
        $this->onePage = $onePage;
        $this->maximum = $maximum;
    }

    /**
     * @return int - retorna o numero de paginas que a paginacao tem
     */
    public function numberPages()
    {
        return ceil($this->maximum / $this->onePage);
    }

    /**
     * Calcula um intervalo de item da pagina atual, exemplo: 0-5, 5-10.
     *
     * @return array - min o numero de inicio e max o numero final da pagina
     */
    public function range()
    {
        if(!isset($_GET['id']))
            $this->page = 1;
        else
            $this->page = $_GET['id'] > 0 ? $_GET['id'] : 1;

        $init = ($this->page - 1) * $this->onePage;

        return ['min' => $init, 'max' => $this->onePage ];
    }

    /**
     * Pega o maximo de itens.
     *
     * @return int - itens
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Armazena um novo numero maximo.
     *
     * @param int $maximum - numero de itens
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
    }

    /**
     * Pega o numero de itens a ser exibidos em uma pagina.
     *
     * @return int
     */
    public function getOnePage()
    {
        return $this->onePage;
    }

    /**
     * Armazena um numero de itens a ser exibido em uma pagina.
     *
     * @param int $onePage
     */
    public function setOnePage($onePage)
    {
        $this->onePage = $onePage;
    }


    /**
     * Pega a pagina atual.
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Altera a pagina atual.
     * 
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }




}