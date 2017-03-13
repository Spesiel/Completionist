<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Sessions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\TokenHelper.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Sessions as Sessions;
use Completionist\Helper\TokenHelper as TokenHelper;

/***********************************************
* Tests on sessions
***********************************************/
$list = array();
/**********************************************/

Tests::run("Sessions", $list);
