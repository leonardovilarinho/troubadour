<?php

class Table
{
    private $database;
    private $name;
    private $columns = array();
    private $pk = array();
    private $foreign = array();
    private $autoincrement;

    private $sql;

    public function database($name)
    {
        $this->database = $name;
        return $this;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function pk($column)
    {
        array_push($this->pk, $column);
        return $this;
    }

    public function column($name, $type, $lenght, $null = true, $default = '')
    {
        $data = array
        (
            'name' => $name,
            'type' => $type,
            'lenght' => $lenght,
            'null' => $null,
            'default' => $default
        );

        array_push($this->columns, $data);
        return $this;
    }

    public function addFK($column, array $reference, $action = 1)
    {
        if($action === 2)
            $action = 'SET NULL';
        elseif($action === 2)
            $action = 'CASCADE';
        elseif($action === 2)
            $action = 'RESTRICT';
        else
            $action = 'NO ACTION';

        $data = array
        (
            'column' => $column,
            'r_table' => $reference[0],
            'r_column' => $reference[1],
            'action' => $action

        );
        array_push($this->foreign, $data);
        return $this;
    }

    public function autoincrement($column)
    {
        $this->autoincrement = $column;
        return $this;

    }

    public function query()
    {
        $this->sql = "CREATE SCHEMA IF NOT EXISTS `{$this->database}` DEFAULT CHARACTER SET utf8 ; USE `mydb` ; ";
        $this->sql .= "CREATE TABLE IF NOT EXISTS `{$this->database}`.`{$this->name}` (";
        $this->generateColumns();
        $this->generatePK();
        $this->generateForeign();
        $this->sql .= ");";
        return $this->sql;
    }

    public function make()
    {
        try
        {
            require_once "kernel/DefaultModel.php";
            $d_model = new DefaultModel();
            if($d_model->sql($this->query()) === false)
            {
                echo 'Erro ao conectar com o banco de dados';
                exit();
            }

        }
        catch (Exception $e)
        {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }

    public function clear()
    {
        $this->database = $this->name = $this->autoincrement = $this->sql = '';
        $this->columns = $this->foreign = $this->pk = array();

        return $this;
    }

    private function generateColumns()
    {
        foreach ($this->columns as $value)
        {
            $null = ($value['null']) ? "NULL" : "NOT NULL";
            $increment = ($this->autoincrement === $value) ? "AUTO_INCREMENT" : "";
            $this->sql .= "`{$value['name']}` {$value['type']} {$null} {$increment} , ";
        }
    }

    private function generatePK()
    {
        if(!empty($this->pk))
        {
            $this->sql .= "PRIMARY KEY(";
            foreach ($this->pk as $value)
                $this->sql .= "`{$value}`,";
            $this->sql = mb_substr($this->sql, 0, -1);
            $this->sql .= ")";
        }
    }

    private function generateForeign()
    {
        if(!empty($this->foreign))
        {
            if(!empty($this->pk))
                $this->sql .= ", ";
            foreach($this->foreign as $value)
            {
                $this->sql .= "INDEX `fk_{$this->name}_{$value['r_table']}_idx` (`{$value['column']}` ASC), ";
            }
            foreach($this->foreign as $value)
            {
                $this->sql .= "CONSTRAINT `fk_{$this->name}_{$value['r_table']}` ";
                $this->sql .= "FOREIGN KEY (`{$value['column']}`) ";
                $this->sql .= "REFERENCES `{$this->database}`.`{$value['r_table']}` (`{$value['r_column']}`)";
                $this->sql .= "ON DELETE {$value['action']} ON UPDATE {$value['action']},";
            }
            $this->sql = mb_substr($this->sql, 0, -1);
        }
    }

}