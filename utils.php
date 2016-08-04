<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:34
 */

Language::init();

//Access::setPrivate(1, "controller1", array("um", "dois"));

Access::setPrivate(1, '*', '*');
Access::setPublic("User", "*");
Access::setPublic("Error", "fail");