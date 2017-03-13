<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Games.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;
use Completionist\Business\Games as Games;

/***********************************************
* Tests on games
***********************************************/
$list = array();
/**********************************************/

Tests::run("Games", $list);
