<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Messages.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Users as Users;
use Completionist\Dao\Messages as Messages;

/***********************************************
* Adding users
***********************************************/
$list = array();

Users::insert("testMessages1", "", "testhash");
Users::insert("testMessages2", "", "testhash");

$result = Users::select();
$list[] = array(
    "Users has 2 entries",
    2,
    $result->rowCount
);
/**********************************************/

/***********************************************
* Tests on messages select/insert/update
***********************************************/
$result = Messages::select();
$list[] = array(
    "Messages should be empty",
    0,
    $result->rowCount
);

$result = Messages::getAll(1);
$list[] = array(
    "Messages for userid=1 should be empty",
    0,
    $result->rowCount
);

Messages::send(1, 2, "this is a title", "this is the body");

$result = Messages::getAll(1);
$list[] = array(
    "Messages for userid=1 has 1 entry",
    1,
    $result->rowCount
);

$result = Messages::getAll(2);
$list[] = array(
    "Messages for userid=2 has 1 entry",
    1,
    $result->rowCount
);

$result = Messages::open(1, 1);
$list[] = array(
    "Messages for userid=1 opening",
    0,
    $result->rowCount
);

$result = Messages::open(2, 1);
$list[] = array(
    "Messages for userid=2 opening",
    1,
    $result->rowCount
);

$result = Messages::delete(2, 1);
$list[] = array(
    "Messages for userid=1 deleting",
    1,
    $result->rowCount
);

$result = Messages::getAll(1);
$list[] = array(
    "Messages for userid=1 getAll",
    1,
    $result->rowCount
);

$result = Messages::getAll(2);
$list[] = array(
    "Messages for userid=2 getAll",
    1,
    $result->rowCount
);
/**********************************************/

Tests::run("Messages", $list);
