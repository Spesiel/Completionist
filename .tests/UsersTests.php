<?php namespace Completionist\Tests;

use Completionist\Dao\Users as Users;

/***********************************************
* Tests on users select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
printf("<h1>Users select/insert/update</h1><hr/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Users::insert("test", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Users::deactivate(1);
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);

$result = Users::insert("test1", "", "testhash0");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");
sleep(2);
$result = Users::update(3, "test1", "", "testhash1");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 4)<br/>");
var_dump($result->rows);
/**********************************************/
