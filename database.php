<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 06/08/16
 * Time: 14:41
 */

$table = new Table();
$table
    ->database('mydb')
    ->name('table1')
    ->pk('id')
    ->autoincrement('id')
    ->column('id', 'int', 11, false, '0')
    ->make();

$table
    ->clear()
    ->database('mydb')
    ->name('table2')
    ->pk('id')
    ->autoincrement('id')
    ->column('id', 'int', 11, false, '0')
    ->make();

$table
    ->clear()
    ->database('mydb')
    ->name('table1_has_table2')
    ->column('table1_id', 'int', false)
    ->column('table2_id', 'int', false)
    ->pk('table1_id')
    ->pk('table2_id')
    ->addFK('table1_id', array('table1', 'id'))
    ->addFK('table2_id', array('table2', 'id'))
    ->make();