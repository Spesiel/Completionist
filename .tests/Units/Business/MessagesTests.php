<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Messages.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;
use Completionist\Business\Messages as Messages;

/***********************************************
* Tests on messages select/insert/update
***********************************************/
$list = array();
/**********************************************/

Tests::run("Messages", $list);
