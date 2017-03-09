<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Friends.php";

use Completionist\Tests\Functions as Tests;
use \Completionist\Dao\Users as Users;
use \Completionist\Dao\Friends as Friends;

/***********************************************
* Tests on friends select/insert/update
***********************************************/
$list = array();

Users::insert("testFriends1", "", "testhash");
Users::insert("testFriends2", "", "testhash");
Users::insert("testFriends3", "", "testhash");

$result = Users::select();
$list[] = array(
    "Users has 3 entries",
    3,
    $result->rowCount
);

/**********************************************/

/***********************************************
* Tests on friends select/insert/update
***********************************************/
$result = Friends::select();
$list[] = array(
    "Friends should be empty",
    0,
    $result->rowCount
);

$result = Friends::request(1, 2);
$list[] = array(
    "Friends requests",
    1,
    $result->rowCount
);

$result = Friends::getRequests(1);
$list[] = array(
    "Friends requests userid=1",
    0,
    $result->rowCount
);

$result = Friends::getRequests(2);
$list[] = array(
    "Friends requests userid=2",
    1,
    $result->rowCount
);

$result = Friends::accept(1, 2);
$list[] = array(
    "Friends accepts userid=1 friendid=2",
    0,
    $result->rowCount
);

$result = Friends::accept(2, 1);
$list[] = array(
    "Friends accepts userid=2 friendid=1",
    1,
    $result->rowCount
);

$result = Friends::getList(1);
$list[] = array(
    "Friends of userid=1",
    1,
    $result->rowCount
);

$result = Friends::getList(2);
$list[] = array(
    "Friends of userid=2",
    1,
    $result->rowCount
);

$result = Friends::remove(2, 1);
$list[] = array(
    "Friends removes userid=2 friendid=1",
    1,
    $result->rowCount
);

$result = Friends::remove(1, 2);
$list[] = array(
    "Friends removes userid=1 friendid=2",
    0,
    $result->rowCount
);

Friends::request(1, 2);
Friends::accept(2, 1);
Friends::remove(1, 2);
Friends::remove(2, 1);
$result = Friends::block(1, 3);
$list[] = array(
    "Friends blocks userid=1 friendid=3",
    1,
    $result->rowCount
);

$result = Friends::request(3, 2);
$list[] = array(
    "Friends requests userid=3 friendid=2",
    1,
    $result->rowCount
);

Friends::accept(2, 3);

$result = Friends::select();
$list[] = array(
    "Friends has 2 entries",
    2,
    $result->rowCount
);
/**********************************************/

Tests::run("Friends", $list);
