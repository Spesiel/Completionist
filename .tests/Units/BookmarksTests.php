<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Bookmarks.php";

use Completionist\Tests\Functions as Tests;
use \Completionist\Dao\Bookmarks as Bookmarks;

/***********************************************
* Tests on bookmarks add/delete
***********************************************/
$list = array();

$result = Bookmarks::select();
$list[] = array(
    "Bookmarks should be empty",
    0,
    $result->rowCount
);

$result = Bookmarks::add(1, 1);
$list[] = array(
    "Bookmarks add: 1 row affected",
    1,
    $result->rowCount
);

$result = Bookmarks::add(1, 3);
$list[] = array(
    "Bookmarks add: 1 row affected",
    1,
    $result->rowCount
);

$result = Bookmarks::add(2, 3);
$list[] = array(
    "Bookmarks add: 1 row affected",
    1,
    $result->rowCount
);

$result = Bookmarks::select();
$list[] = array(
    "Bookmarks has 3 entries",
    3,
    $result->rowCount
);

$result = Bookmarks::remove(1, 3);
$list[] = array(
    "Bookmarks remove: 1 entry affected",
    1,
    $result->rowCount
);

$result = Bookmarks::select();
$list[] = array(
    "Bookmarks has 2 entries",
    2,
    $result->rowCount
);
/**********************************************/

Tests::run("Bookmarks", $list);
