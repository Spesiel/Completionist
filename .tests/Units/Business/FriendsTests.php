<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Friends.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;
use Completionist\Business\Friends as Friends;

/***********************************************
* Tests on friends
***********************************************/
$list = array();
/**********************************************/

Tests::run("Friends", $list);
