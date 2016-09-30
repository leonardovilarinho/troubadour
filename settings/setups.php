<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:43
 */
use LegionLab\Troubadour\Collections\Settings;

date_default_timezone_set("America/Sao_Paulo");

/*
* Define variables from development, logs to register log of errors and success in folder 'logs',
* deployment enable the use of migration and other, ignoreErrors omits the PHP error, notice, warning..
*/
Settings::set('logs', true);
Settings::set('deployment', true);
Settings::set('ignoreErrors', false);

/*
* To use this API, set in array as tokens are allowed in secret remote access
*/
Settings::set('allowsAjax', array('myIDAjaxAllowCrypt'));

/*
* Style files and javascript standard on all system pages, specified path taking the public directory as root
*/
Settings::set('defaultCSS', array(
    "/librarys/bootstrap/css/bootstrap.css"
));
Settings::set('defaultJS', array(
    "/librarys/jquery.min.js",
    "/librarys/bootstrap/js/bootstrap.min.js"
));

/*
* Settings to use the database, dbhost, dbuser, dbpassword and one defalt database to connection
*/
Settings::set("dbhost", "localhost");
Settings::set("dbuser", "root");
Settings::set("dbpassword", "sim-605");
Settings::set("default_dbname", "db_thelice");

/*
* Adding methods to be loaded at all times, an example to use would be for a cart of an online store, or a dynamic menu.
* array key is controller and value is method
*/
Settings::set('methodsStart', null); //array("Dynamic" => "menu")

/*
* Extension to archives of languages
*/
Settings::set("langExtension", ".lang");

/*
* Define home page, whit controller and method
*/
Settings::set("initialController", "Home");
Settings::set("initialMethod", "page");

/*
* Others settings, as handle of acces and user and default template
*/
Settings::set("accessIndentifier", "area");
Settings::set("userIndentifier", "user");
Settings::set("skeleton", "default");

/*Settings::set("paypal_p_user", "");
Settings::set("paypal_p_password", "");
Settings::set("paypal_p_signature", '');

Settings::set("paypal_s_user", "");
Settings::set("paypal_s_password", "");
Settings::set("paypal_s_signature", '');*/
