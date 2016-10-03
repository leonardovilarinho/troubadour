<?php

use LegionLab\Troubadour\Persistence\Migration;
use LegionLab\Troubadour\Persistence\DefaultModel;

/*
* For specific use in the DEVELOPMENT, creates and modifies the database according
* to the configuration of this file
*
* Example:
* $table = new Migration(); | create instance
* $table
*    ->database('db_thelice')                   | select database
*    ->name('category')                         | add name of table
*    ->pk('id')                                 | set primary key
*    ->autoincrement('id')                      | set autoincrement
*    ->column('id', 'int', 11, false)           | create column with name 'id', int, length 11 and not null
*    ->column('name', 'varchar', 50, false)     | create column with name 'name', varchar, length 50 and not null
*    ->make();                                  | Execute query for create or edit this table
* $table->clear(); | Clear previous table settings to be able to build another table
*/

/*
* To insert default data in database, use:
*
* $d_model = new DefaultModel(); | Instace of default model
*
* Verify if table is empty
* $result = $d_model->sql("SELECT COUNT(*) as cnt FROM category;")[0]['cnt'];
*
* if($result <= 1) | if is empty
* {
*    run this sql, array() is params  to bind, false to development
*    $d_model->sql
*    (
*        "SQL Query", array(), false
*    );
* }
*/
