<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Users as Users;

/***********************************************
* Tests on users select/insert/update
***********************************************/
$list = array();

$result = Users::select();
$list[] = array(
    "Users should be empty",
    0,
    $result->rowCount
);

$result = Users::insert("test", "", "testhash");
$list[] = array(
    "Users insert: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::select();
$list[] = array(
    "Users has 1 entry",
    1,
    $result->rowCount
);

$result = Users::deactivate(1, 1);
$list[] = array(
    "Users deactivation: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::activate(1, 1);
$result = Users::select();
$list[] = array(
    "Users has 3 entry",
    3,
    $result->rowCount
);

$result = Users::insert("test1", "", "testhash0");
$list[] = array(
    "Users insert: 1 row affected",
    1,
    $result->rowCount
);
sleep(2);
$result = Users::update(4, "test1", "", "testhash1", 4);
$list[] = array(
    "Users update: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::select();
$list[] = array(
    "Users has 5 entry",
    5,
    $result->rowCount
);
/**********************************************/

Tests::run("Users", $list);
