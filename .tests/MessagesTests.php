<?php namespace Completionist\Tests;

/***********************************************
* Adding users
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";
printf("<h1>Users insert</h1><hr/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Users::insert("testMessages1", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::insert("testMessages2", "", "testhash");
printf("Users: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Users::select();
printf("Users has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);
/**********************************************/

/***********************************************
* Tests on messages select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Messages.php";
printf("<h1>Messages select/insert/update</h1><hr/>");

$result = Messages::select();
printf("Messages has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Messages::getAll(1);
printf("Messages for userid=1 has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Messages::send(1, 2, "this is a title", "this is the body");
printf("Messages for userid=1 has: ".$result->rowCount." entries<br/>");
var_dump($result);

$result = Messages::getAll(1);
printf("Messages for userid=1 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Messages::getAll(2);
printf("Messages for userid=2 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Messages::open(1, 1);
printf("Messages for userid=1 has: ".$result->rowCount." entries (should be 0)<br/>");
var_dump($result->rows);

$result = Messages::open(2, 1);
printf("Messages for userid=2 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Messages::delete(2, 1);
printf("Messages for userid=2 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result);

$result = Messages::getAll(1);
printf("Messages for userid=1 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Messages::getAll(2);
printf("Messages for userid=2 has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);
