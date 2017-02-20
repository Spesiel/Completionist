<?php namespace Completionistv2;

printf("<h1>Tests</h1><hr/>");

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
printf("Password checks hash: $compare<br/>");
/**********************************************/

/***********************************************
* Tests on tokenHelper
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";
printf("<h1>TokenHelper</h1><hr/>");

printf("Payload: name is test");
$payload = array("name"=>"test");
var_dump($payload);
$token = TokenHelper::encode($payload);
var_dump($token);
$newPayload = TokenHelper::decode($token);
var_dump($newPayload);
printf("Different payload: name is test2");
$diffPayload = TokenHelper::decode(
    "eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdDIifQ.4aWmIAbncNwvL31_Pml8wjr1DO44Bpoi0g4APrHxMxY"
);
var_dump($diffPayload);
/**********************************************/

/***********************************************
* Tests on select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";
printf("<h1>Users select/insert/update</h1><hr/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Users::insert("test", "", "testhash");
printf("Users has: ".$result->rowCount." entries (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Users::deactivate("test");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Users::insert("test1", "", "testhash0");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");
sleep(2);
$result = Users::update(2, "test1", "", "testhash1");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 3)<br/>");
var_dump($result->rows);
/**********************************************/

printf("<hr/><hr/><h1>Reset</h1><hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/reset.php";
