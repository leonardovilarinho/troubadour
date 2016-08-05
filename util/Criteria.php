<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 12:26
 */

class Criteria
{
    /**
     * Atributos privados
     */
    private $values = array(); // valores do bind a serem executados por Database
    private $where = ""; // string montada de uma condição WHERE
    private $order = ""; // string contendo a ordem da SQL quando informada
    private $limit = ""; // string contendo o limite quando informado
    private $signs = array('=', '!=', '<', '>', '<=', '>=', '<>', 'LIKE'); // arrray de sinais

    private $tables = ""; // string com tabelas atuais do criteria
    private $select = "*"; // todas colunas a serem exibidas


    /**
     * Armazena na variavel select uma string com os argumentos passados, ja no formato de uma
     * SQL.
     */
    public function displays()
    {
        $this->select = $this->dispatch(func_get_args());
        return $this;
    }

    /**
     * Faz o mesmo que o método displays, só que com as tabelas a serem usadas nessa criteria,
     * formata para ser colocada na SQL resultante
     */
    public function tables()
    {
        $this->tables = $this->dispatch(func_get_args());
        return $this;
    }

    /**
     * Adiciona uma condição OR na SQL atual, o método apenas chama o build
     * passando os parametros recebidos e a tag OR.
     *
     * @param $column - coluna a comparar
     * @param $sign - sinal de comparação
     * @param $value - valor a ser comaparado
     */
    public function _or($column, $sign, $value)
    {
        $this->build($column, $sign, $value, 'OR');
        return $this;
    }

    /**
     * Adiciona uma condição AND na SQL atual, o método apenas chama o build
     * passando os parametros recebidos e a tag AND.
     *
     * @param $column - coluna a comparar
     * @param $sign - sinal de comparação
     * @param $value - valor a ser comaparado
     */
    public function _and($column, $sign, $value)
    {
        $this->build($column, $sign, $value, 'AND');
        return $this;
    }

    /**
     * Adiciona um limite de resutaldas na SQL, onde pode ser informad um limit simples
     * ou uma origem ou fim para esssa selação.
     *
     * @param $limit - limite simples, informando quantos deveram ser retornados
     * @param null $home - inicio a ser buscado o limite
     */
    public function limit($limit, $home = null)
    {
        if(filter_var($limit, FILTER_VALIDATE_INT))
        {
            if(!is_null($home) and filter_var($home, FILTER_VALIDATE_INT))
                $this->limit = " LIMIT {$home}, {$limit} ";
            else
                $this->limit = " LIMIT {$limit} ";
        }
        return $this;
    }

    /**
     * Define uma ordem para SQL seguir, informado a coluna da tabela e o sinal de ordenação.
     *
     * @param string $column - coluna do banco
     * @param string $order - +/- indicando a ordem de listagem
     */
    public function order($column = 'id', $order = '+')
    {
        if($order === '+')
            $this->order = " ORDER BY {$column} ASC ";
        else if($order === '-')
            $this->order = " ORDER BY {$column} DESC ";
        return $this;
    }

    private function dispatch($param)
    {
        $var = "";
        foreach ($param as $value)
            if(is_string($value))
                $var .= " {$value},";
        return mb_substr($var, 0, -1) . " ";
    }

    /**
     * Adiciona elementos na SQL, na where, fazendo controle de quando é um bind ou é comparação
     * entre colunas de tabelas distintas.
     *
     * @param $column - coluna a ser inserida no WHERE
     * @param $sign - sinal a ser inserido no WHERE
     * @param $value - valor para a comparação
     * @param $text - tipo de condição AND/OR
     */
    private function build($column, $sign, $value, $text)
    {
        $sign = mb_strtoupper($sign);
        if(in_array($sign, $this->signs))
        {
            if(empty($this->where))
            {
                $this->where = " WHERE {$column} {$sign}  :" . str_replace('.', '', $column) . " ";
                $this->values[$column] = $value;
            }
            else
            {
                if(mb_stripos($this->tables, @explode('.', $value)[0]))
                    $this->where .= " {$text} {$column} {$sign} {$value} ";
                else
                {
                    $this->where .= " {$text} {$column} {$sign} :" . str_replace('.', '', $column) . " ";
                    $this->values[$column] = $value;
                }
            }

        }
    }

    /**
     * Getters e Setters
     */

    /**
     * @return string
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @return string
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * @return string
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Retorna array de valores retirando o . em chaves que tem tabela.coluna
     * 
     * @return array
     */
    public function getValues()
    {
        $return = array();
        foreach ($this->values as $key => $value)
        {
            $return[str_replace('.', '', $key)] = $value;
        }
        return $return;
    }

    public function clear()
    {

        $this->values  = array(); 
        $this->where = $this->order = $this->limit = $this->tables = ""; 
        $this->select = "*";

        return $this;
    }


}