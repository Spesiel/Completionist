<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Bookmarks.php";

use Completionist\Tests\Functions as Tests;
use \Completionist\Business\Bookmarks as Bookmarks;

/***********************************************
* Tests on bookmarks
***********************************************/
$list = array();
/**********************************************/

Tests::run("Bookmarks", $list);
