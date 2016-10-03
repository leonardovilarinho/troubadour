<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 26/08/16
 * Time: 11:40
 */
use LegionLab\Troubadour\Routes\Access;
use LegionLab\Utils\Language;

// Start default language from browser
Language::init(ROOT.'settings/languages/');

/*
* Set access definitions, routes public and privates by user type
*
* Examples public:
* Access::setPublic('Home', '*'); | All method of HomeController allowed
* Access::setPublic('Category', array('view', 'create')); | view and create method allowed
*
* Example private:
* Access::setPrivate(1, '*', '*'); | All routes from user type 1
*/

Access::setPublic('*', '*');
