<?php namespace Completionist\Tests;

use \Completionist\Dao\Users as Users;
use \Completionist\Dao\Friends as Friends;

/***********************************************
* Tests on friends select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
printf("<h1>Users insert</h1><hr/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Users::insert("testFriends1", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::insert("testFriends2", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);
/**********************************************/

/***********************************************
* Tests on friends select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Friends.php";
printf("<h1>Friends select/insert/update</h1><hr/>");

$result = Friends::select();
printf("Friends has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Friends::request(1, 2);
printf("Friends request: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::getRequests(1);
printf("Friends list requests: ".$result->rowCount." entries (should be 0)<br/>");

$result = Friends::getRequests(2);
printf("Friends list requests: ".$result->rowCount." entries (should be 1)<br/>");

$result = Friends::accept(1, 2);
printf("Friends accept: ".$result->rowCount." row affected (should be 0)<br/>");

$result = Friends::accept(2, 1);
printf("Friends accept: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::getList(2);
printf("Friends has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Friends::remove(2, 1);
printf("Friends remove: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::remove(1, 2);
printf("Friends remove: ".$result->rowCount." row affected (should be 0)<br/>");

$result = Friends::request(1, 2);
printf("Friends request: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::accept(2, 1);
printf("Friends accept: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::remove(1, 2);
printf("Friends remove: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Friends::remove(2, 1);
printf("Friends remove: ".$result->rowCount." row affected (should be 0)<br/>");

$result = Friends::select();
printf("Friends has: ".$result->rowCount." entries (should be 0)<br/>");
var_dump($result->rows);
