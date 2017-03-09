<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Users as Users;

/***********************************************
* Adding users
***********************************************/
Users::insert("test1", "", "testhash");
Users::insert("test2", "", "testhash");

/**********************************************/

/***********************************************
* Tests on Users->role select/update
***********************************************/
$list = array();

$result = Users::setRole(1, "admin");
$list[] = array(
    "Users->role: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::setRole(2, "poweruser");
$list[] = array(
    "Users->role: 1 row affected",
    1,
    $result->rowCount
);

$result = Users::getRole(1);
$list[] = array(
    "Users->role: check value userid=1",
    "admin",
    $result
);
/**********************************************/

Tests::run("Users->role", $list);
