<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\PasswordHelper.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Helper\PasswordHelper as PasswordHelper;

printf("<h1>PasswordHelper</h1><hr/>");

/***********************************************
* Tests on passwordHelper
***********************************************/

$password = "testing the capabilities of encoding passwords";
$hash = PasswordHelper::encode($password);

$list = array();
$list[] = array(
    "Encoded password",
    "ZWIyNWRmMzE2YjEzNWY3ZTM3YWIzNDBlMDY5ZGQ2OGQ3YTdkNDcwZWViNjM5MzhlOWNmMGNjZDdlYjAyN2Q4Mg",
    $hash
);
$list[] = array(
    "Password checks hash",
    true,
    PasswordHelper::check($password, $hash)
);
$list[] = array(
    "Password checks hash",
    false,
    PasswordHelper::check("wrong password", $hash)
);
/**********************************************/

Tests::assertions($list);
