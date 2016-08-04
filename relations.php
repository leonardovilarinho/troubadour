<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 05/07/2016
 * Time: 14:56
 */
//Relationships::set("Daddy", array("People"));

Relationships::set("Book", array("User"));

Relationships::set("Chapter", array("Book"));