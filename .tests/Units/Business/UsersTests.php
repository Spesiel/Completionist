<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;

/***********************************************
* Tests on users
***********************************************/
$list = array();
/**********************************************/

Tests::run("Users", $list);
