<?php namespace Completionist\Tests;

use Completionist\Dao\Users as Users;
use Completionist\Dao\Games as Games;

/***********************************************
* Adding users
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
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
* Tests on games select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Games.php";
printf("<h1>Games select/insert/update</h1><hr/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Games::insert("game0", "link", "comment", 1);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::lock(1, 1);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries (should be 2)<br/>");

$result = Games::insert("game1", "link", "comment", 2);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");
sleep(1);
$result = Games::update(3, "game1 updated", "link", "comment updated", 2);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::insertSub(3, "game1 sub", "link sub", "comment sub", 2);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::update(5, "game1 sub updated", "link sub updated", "comment sub updated", 2);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries (should be 6)<br/>");
var_dump($result->rows);
/**********************************************/
