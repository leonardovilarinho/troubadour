<?php

namespace LegionLab\Troubadour\Persistence;

class Migration
{
    private $database;
    private $name;
    private $columns = array();
    private $pk = array();
    private $foreign = array();
    private $autoincrement;
    private $attrs = array();
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
        $data = array(
            'name' => $name,
            'type' => $type,
            'lenght' => $lenght,
            'null' => $null,
            'default' => $default
        );

        array_push($this->columns, $data);
        array_push($this->attrs, $name);
        return $this;
    }

    public function addFK($column, array $reference, $action = 1)
    {
        if($action === 2)
            $action = 'SET NULL';
        elseif($action === 3)
            $action = 'CASCADE';
        elseif($action === 4)
            $action = 'RESTRICT';
        else
            $action = 'NO ACTION';

        $data = array(
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
        $this->sql = "CREATE TABLE IF NOT EXISTS `{$this->database}`.`{$this->name}` (";
        $this->generateColumns();
        $this->generatePK();
        $this->generateForeign();
        $this->sql .= ");";
        return $this->sql;
    }

    public function make()
    {
        try {
            $d_model = new DefaultModel();

            if($d_model->sql("CREATE SCHEMA IF NOT EXISTS `{$this->database}` DEFAULT CHARACTER SET utf8mb4;", array(), false) !== false) {
                $d_model->sql("USE {$this->database};", array(), false);
                if($d_model->sql("SHOW TABLES LIKE '{$this->name}';", array(), false) > 0) {
                    $table = $d_model->sql("DESCRIBE {$this->name};");

                    $fields = array();
                    foreach ($table as $value) {
                        if(!in_array($value['Field'], $this->attrs))
                            $d_model->sql("ALTER TABLE `{$this->name}` DROP `{$value['Field']}`;");
                        else
                            array_push($fields, $value['Field']);
                    }

                    foreach ($this->attrs as $key => $attr) {
                        $value = $this->columns[$key];
                        $increment = $this->defineIncrement($value);
                        $null = $this->defineNull($value);
                        $lenght = $this->defineLenght($value);
                        $lenght = ($lenght > 0) ? "($lenght)" : "";
                        $default = $this->defineDefault($value);


                        if(!in_array($attr, $fields)) {
                            $d_model->sql(
                                "ALTER TABLE `{$this->name}` ADD `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment} AFTER `{$this->attrs[0]}`;"
                            );
                        }
                        else {
                            if(!empty($increment)) {
                                if($table[array_search($attr, $fields)]['Extra'] != 'auto_increment') {
                                    $d_model->sql(
                                        "ALTER TABLE `{$this->name}` ADD PRIMARY KEY(`{$attr}`);"
                                    );

                                    $d_model->sql(
                                        "ALTER TABLE `{$this->name}` CHANGE `{$attr}` `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment};"
                                    );
                                }
                            }
                            $null2 = ($null == "NULL") ? "YES" : "NO";
                            if($table[array_search($attr, $fields)]['Null'] != $null2) {
                                $d_model->sql(
                                    "ALTER TABLE `{$this->name}` CHANGE `{$attr}` `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment};"
                                );
                            }

                            if(explode("(", $table[array_search($attr, $fields)]['Type'])[0] != $value['type']) {
                                $d_model->sql(
                                    "ALTER TABLE `{$this->name}` CHANGE `{$attr}` `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment};"
                                );
                            }

							$len = (isset(explode("(", $table[array_search($attr, $fields)]['Type'])[1])) ? explode("(", $table[array_search($attr, $fields)]['Type'])[1] : '';

                            if(mb_substr($len, 0, -1) != str_replace('(', '', str_replace(')', '', $lenght))) {
                                $d_model->sql(
                                    "ALTER TABLE `{$this->name}` CHANGE `{$attr}` `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment};"
                                );
                            }

                            if($table[array_search($attr, $fields)]['Default'] != trim(str_replace("DEFAULT", "", $value['default']))) {
                                $d_model->sql(
                                    "ALTER TABLE `{$this->name}` CHANGE `{$attr}` `{$attr}` {$value['type']}{$lenght} {$null} {$default} {$increment};"
                                );
                            }
                        }
                    }

                }
                else {
                    if($d_model->sql($this->query(), array(), false) === false) {
                        echo 'Erro ao conectar com o banco de dados';
                        exit();
                    }
                }
            }
            else {
                echo 'Erro ao criar o banco de dados';
                exit();

            }


        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }

    public function clear()
    {
        $this->database = $this->name = $this->autoincrement = $this->sql = '';
        $this->columns = $this->foreign = $this->pk = $this->attrs = $this->describe = array();

        return $this;
    }

    private function generateColumns()
    {
        foreach ($this->columns as $value) {
            $null = $this->defineNull($value);
            $increment = $this->defineIncrement($value);
            $lenght = $this->defineLenght($value);
            $lenght = ($lenght > 0) ? "($lenght)" : "";
            $this->sql .= "`{$value['name']}` {$value['type']}{$lenght} {$null} {$increment} {$this->defineDefault($value)} , ";
        }
    }

    private function defineDefault($value)
    {
        if($value['default'] !== '') {
            if(is_null($value['default']))
                return "DEFAULT NULL";
            elseif(is_numeric($value['default']))
                return "DEFAULT {$value['default']}";
            else
                return "'DEFAULT {$value['default']}    ";
        }
        else
            return  '';
    }

    private function defineNull($value)
    {
        return ($value['null']) ? "NULL" : "NOT NULL";
    }

    private function defineIncrement($value)
    {
        return ($this->autoincrement == $value['name']) ? "AUTO_INCREMENT" : "";
    }

    private function defineLenght($value)
    {
        if($value['lenght'] == 0) {
            switch (trim(mb_strtolower($value['type']))) {
                case 'varchar':
                    return 255;
                    break;
                case 'char':
                    return 255;
                    break;
                case 'int':
                    return 11;
                    break;
                default:
                    return '';
                    break;
            }
        }
        else
            return $value['lenght'];
    }

    private function generatePK()
    {
        $this->sql = mb_substr($this->sql, 0, -2);
        if(!empty($this->pk)) {
            $this->sql .= ", PRIMARY KEY(";
            foreach ($this->pk as $value)
                $this->sql .= "`{$value}`,";
            $this->sql = mb_substr($this->sql, 0, -1);
            $this->sql .= ")";
        }
    }

    private function generateForeign()
    {
        if(!empty($this->foreign)) {
            if(!empty($this->pk))
                $this->sql .= ", ";
            foreach($this->foreign as $value) {
                $this->sql .= "INDEX `fk_{$this->name}_{$value['r_table']}_idx` (`{$value['column']}` ASC), ";
            }
            foreach($this->foreign as $value) {
                $this->sql .= "CONSTRAINT `fk_{$this->name}_{$value['r_table']}` ";
                $this->sql .= "FOREIGN KEY (`{$value['column']}`) ";
                $this->sql .= "REFERENCES `{$this->database}`.`{$value['r_table']}` (`{$value['r_column']}`)";
                $this->sql .= "ON DELETE {$value['action']} ON UPDATE {$value['action']},";
            }
            $this->sql = mb_substr($this->sql, 0, -1);
        }
    }

}
