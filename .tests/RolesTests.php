<?php namespace Completionist\Tests;

use Completionist\Dao\Users as Users;

/***********************************************
* Adding users
***********************************************/
printf("<h1>Users insert</h1><hr/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Users::insert("test1", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::insert("test2", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);
/**********************************************/

/***********************************************
* Tests on Users->role select/update
***********************************************/
printf("<h1>Users->role select/update</h1><hr/>");

$result = Users::setRole(1, "admin");
var_dump($result);

$result = Users::setRole(2, "poweruser");
var_dump($result);

$result = Users::getRole(1);
var_dump($result);

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 4)<br/>");
var_dump($result->rows);
