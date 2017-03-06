<?php namespace Completionist\Tests;

use Completionist\Helper\PasswordHelper as PasswordHelper;

/***********************************************
* Tests on passwordHelper
***********************************************/
printf("<h1>PasswordHelper</h1><hr/>");

$password = "testing the capabilities of encoding passwords";
printf("Password: $password<br/>");
$hash = PasswordHelper::encode($password);
printf("Encoded password: $hash<br/>");
$compare = PasswordHelper::check($password, $hash);
printf("Password checks hash: $compare (should be 1)<br/>");
$compare = PasswordHelper::check("wrong password", $hash);
printf("Password checks hash: ".(!$compare?"null":"1")." (should be null)<br/>");
/**********************************************/
