<?php namespace Completionistv2;

/***********************************************
* Tests on passwordHelper
************************************************
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\PasswordHelper.php";

$password = "testing the capabilities of encoding passwords";
var_dump($password);
$hash = PasswordHelper::encode($password);
var_dump($hash);
$compare = PasswordHelper::check($password, $hash);
var_dump($compare);
***********************************************/

/***********************************************
* Tests on select/insert/update
************************************************
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);

$result = Users::insert("test", "", "testhash");
echo "Count: ".$result->rowCount;

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);

$result = Users::deactivate("test");
echo "Count: ".$result->rowCount;

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);
***********************************************/

/***********************************************
* Tests on select/insert/update
************************************************
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";

$result = Users::select();
echo "Count: ".$result->rowCount."<br/>";
var_dump($result->rows);

$result = Users::insert("test", "", "testhash0");
echo "Count: ".$result->rowCount;
sleep(2);
$result = Users::update(1, "test", "", "testhash1");
echo "Count: ".$result->rowCount."<br/>";

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);
***********************************************/
