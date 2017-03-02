<?php namespace Completionist\Tests;

use Completionist\Dao\Games as Games;

/***********************************************
* Tests on games select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Games.php";
printf("<h1>Games select/insert/update</h1><hr/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Games::insert("game", "link", "comment", 1);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Games::lock(1, 1);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);

$result = Games::insert("game1", "link", "comment", 3);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");
sleep(2);
$result = Games::update(3, "game1 updated", "link", "comment updated", 3);
printf("Games: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Games::select();
printf("Games has: ".$result->rowCount." entries (should be 4)<br/>");
var_dump($result->rows);
/**********************************************/
