<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 06/08/16
 * Time: 14:41
 */

$table = new Table();

$table
    ->database('bookcase')
    ->name('users')
    ->pk('id')
    ->autoincrement('id')
    ->column('id', 'int', 11, false)
    ->column('username', 'varchar', 40, false)
    ->column('password', 'varchar', 255, false)
    ->make();
$table
    ->clear()
    ->database('bookcase')
    ->name('books')
    ->pk('id')
    ->autoincrement('id')
    ->column('id', 'int', 11, false)
    ->column('name', 'varchar', 100, false)
    ->column('author', 'varchar', 50, false)
    ->column('price', 'double', 0, false)
    ->column('user', 'int', 0, false)
    ->addFK('user', array('users', 'id'), 3)
    ->make();

$table
    ->clear()
    ->database('bookcase')
    ->name('chapters')
    ->column('id', 'int', 11, false)
    ->autoincrement('id')
    ->column('title', 'varchar', 100, false)
    ->column('pages', 'int', 5, false, '1')
    ->column('book', 'int', 11, false)
    ->pk('id')
    ->addFK('book', array('books', 'id'))
    ->make();

//echo $table->query();