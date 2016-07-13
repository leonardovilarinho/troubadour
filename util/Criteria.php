<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 12:26
 */

class Criteria
{
    private $values = array();
    private $where = "";
    private $order = "";
    private $limit = "";
    private $signs = array('=', '!=', '<', '>', '<=', '>=', '<>', 'LIKE');

    private $tables = "";
    private $select = "*";

    public function displays()
    {
        $this->select = $this->dispatch(func_get_args());
    }

    public function tables()
    {
        $this->tables = $this->dispatch(func_get_args());
    }

    public function _or($column, $sign, $value)
    {
        $this->build($column, $sign, $value, 'OR');
    }

    public function _and($column, $sign, $value)
    {
        $this->build($column, $sign, $value, 'AND');
    }

    public function limit($limit, $home = null)
    {
        if(filter_var($limit, FILTER_VALIDATE_INT))
        {
            if(!is_null($home) and filter_var($home, FILTER_VALIDATE_INT))
                $this->limit = " LIMIT {$home}, {$limit} ";
            else
                $this->limit = " LIMIT {$limit} ";
        }
    }

    public function order($column = 'id', $order = '+')
    {
        if($order === '+')
            $this->order = " ORDER BY {$column} ASC ";
        else if($order === '-')
            $this->order = " ORDER BY {$column} DESC ";
    }

    private function dispatch($param)
    {
        $var = "";
        foreach ($param as $value)
            if(is_string($value))
                $var .= " {$value},";
        return mb_substr($var, 0, -1) . " ";
    }

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



}