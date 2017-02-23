<?php namespace Completionistv2;

/***********************************************
* Tests on passwordHelper
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\PasswordHelper.php";
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
