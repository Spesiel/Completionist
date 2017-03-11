<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Games.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Users as Users;
use Completionist\Dao\Games as Games;

/***********************************************
* Adding users
***********************************************/
$list = array();

$result = Users::select();
$list[] = array(
    "Users should be empty",
    0,
    $result->rowCount
);

$result = Users::insert("test1", "", "testhash");
$list[] = array(
    "Users insert: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::insert("test2", "", "testhash");
$list[] = array(
    "Users insert: 1 row affected",
    1,
    $result->rowCount
);

/**********************************************/

/***********************************************
* Tests on games select/insert/update
***********************************************/
$result = Games::select();
$list[] = array(
    "Games should be empty",
    0,
    $result->rowCount
);

$result = Games::insert("game0", "link", "comment", 1);
$list[] = array(
    "Games has 1 entry",
    1,
    $result->rowCount
);

$result = Games::lock(1, 1);
$list[] = array(
    "Games locked: 1 row affected",
    1,
    $result->rowCount
);

$result = Games::select();
$list[] = array(
    "Games has 2 entry",
    2,
    $result->rowCount
);

$result = Games::insert("game1", "link", "comment", 2);
$list[] = array(
    "Games insert: 1 row affected",
    1,
    $result->rowCount
);
$result = Games::update(3, "game1 updated", "link", "comment updated", 2);
$list[] = array(
    "Games update: 1 row affected",
    1,
    $result->rowCount
);

Games::insertSub(3, "game1 sub", "link sub", "comment sub", 2);
Games::update(5, "game1 sub updated", "link sub updated", "comment sub updated", 2);
Games::insertSub(5, "game1 sub sub 1", "link sub sub", "comment sub sub", 2);
Games::insertSub(7, "game1 sub sub 1 leaf 1", "link sub sub leaf", "comment sub sub leaf", 2);
Games::insertSub(7, "game1 sub sub 1 leaf 2", "link sub sub leaf", "comment sub sub leaf", 2);
Games::insertSub(5, "game1 sub sub 2", "link sub sub", "comment sub sub", 2);
Games::insertSub(10, "game1 sub sub 2 leaf 1", "link sub sub leaf", "comment sub sub leaf", 2);
Games::insertSub(10, "game1 sub sub 2 leaf 2", "link sub sub leaf", "comment sub sub leaf", 2);

$result = Games::getList();
$list[] = array(
    "Games: 2 items in list",
    2,
    $result->rowCount
);

$result = Games::select();
$list[] = array(
    "Games has 12 entry",
    12,
    $result->rowCount
);
/**********************************************/

Tests::run("Games", $list);
