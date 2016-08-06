<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:43
 */
date_default_timezone_set("America/Sao_Paulo");

Settings::set('logs', false);
Settings::set('deployment', true);
Settings::set('ignoreErrors', false);

Settings::set("default_dbhost", "localhost");
Settings::set("default_dbuser", "root");
Settings::set("default_dbpassword", "sim-605");
Settings::set("default_dbname", "bookcase");

Settings::set("langExtension", ".lang");

Settings::set("initialController", "User");
Settings::set("initialMethod", "login");

Settings::set("userIndentifier", "area");
Settings::set("skeleton", "default");

Settings::set("unview", array("delete", "edit", "change", "login", "register", "fail", "details", "create", 'logout'));

//or Settings::set("disableUtil", 'Language'); or Settings::set("disableUtil", false);
Settings::set("disableUtil", array('Cookies', 'ValidatePost'));