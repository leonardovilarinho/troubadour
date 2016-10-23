<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 11/07/2016
 * Time: 20:12
 */

use LegionLab\Troubadour\Routes\Alias;

/*
* Create shortcuts to routes, example mysite.com/account/list be accessible also by mysite.com/c
* Example:
* Alias::set('Account', 'list', 'c'); | The method listDeed of AccountController can be accessed by 'c'
*/

Alias::set('Error', 'fail', 'error');
