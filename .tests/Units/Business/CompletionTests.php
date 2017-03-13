<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Games.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Completion.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;
use Completionist\Business\Games as Games;
use Completionist\Business\Completion as Completion;

/***********************************************
* Tests on completion
***********************************************/
$list = array();
/**********************************************/

Tests::run("Completion", $list);
