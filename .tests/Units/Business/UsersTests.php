<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Business\Users as Users;

/***********************************************
* Tests on users
***********************************************/
$list = array();

$result = Users::checkName("admin");
$list[] = array(
    "Users: name not taken",
    0,
    $result->result
);

$result = Users::create("admin", null, "password");
$list[] = array(
    "Users: created account",
    true,
    $result->result
);

$result = Users::create("admin", null, "blah");
$list[] = array(
    "Users: account already exists",
    false,
    $result->result
);

$result = Users::checkName("admin");
$list[] = array(
    "Users: name taken",
    1,
    $result->result
);

$result = Users::checkName("admi");
$list[] = array(
    "Users: name not taken",
    0,
    $result->result
);

$result = Users::checkName("admini");
$list[] = array(
    "Users: name not taken",
    0,
    $result->result
);

$result = Users::update(1, "admin", null, "wrong", "newPassword");
$list[] = array(
    "Users update: wrong password",
    1,
    count($result->errors)
);

$result = Users::update(1, "admin", null, "password", "newPassword");
$list[] = array(
    "Users update: account updated",
    true,
    $result->result
);

$result = Users::getRole(1);
$list[] = array(
    "Users role: is user",
    "user",
    $result->result
);

$result = Users::setRole(1, 127, 1);
$list[] = array(
    "Users role: set to admin",
    1,
    $result->result
);

$result = Users::getRole(1);
$list[] = array(
    "Users role: is admin",
    "admin",
    $result->result
);

$result = Users::setRole(1, 63, 1);
$list[] = array(
    "Users role: set to poweruser",
    1,
    $result->result
);

$result = Users::getRole(1);
$list[] = array(
    "Users role: is poweruser",
    "poweruser",
    $result->result
);

$result = Users::setRole(1, 1, 1);
$list[] = array(
    "Users role: set to user",
    1,
    $result->result
);

$result = Users::getRole(1);
$list[] = array(
    "Users role: is user",
    "user",
    $result->result
);

$result = Users::getStatus(1);
$list[] = array(
    "Users status: is enabled",
    true,
    $result->result
);

$result = Users::disable(1, 1);
$list[] = array(
    "Users status: set disabled",
    1,
    $result->result
);

$result = Users::getStatus(1);
$list[] = array(
    "Users status: is disabled",
    false,
    $result->result
);

$result = Users::enable(1, 1);
$list[] = array(
    "Users status: set enabled",
    1,
    $result->result
);

$result = Users::getStatus(1);
$list[] = array(
    "Users status: is enabled",
    true,
    $result->result
);
/**********************************************/

Tests::run("Users", $list);
