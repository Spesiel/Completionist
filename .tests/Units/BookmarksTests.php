<?php namespace Completionist\Tests;

use \Completionist\Dao\Bookmarks as Bookmarks;

/***********************************************
* Tests on bookmarks add/delete
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Bookmarks.php";
printf("<h1>Bookmarks add/delete</h1><hr/>");

$result = Bookmarks::select();
printf("Bookmarks has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Bookmarks::add(1, 1);
printf("Bookmarks: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Bookmarks::select();
printf("Bookmarks has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Bookmarks::add(3, 1);
printf("Bookmarks: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Bookmarks::select();
printf("Bookmarks has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);

$result = Bookmarks::add(3, 3);
printf("Bookmarks: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Bookmarks::select();
printf("Bookmarks has: ".$result->rowCount." entries (should be 3)<br/>");
var_dump($result->rows);

$result = Bookmarks::remove(3, 1);
printf("Bookmarks: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Bookmarks::select();
printf("Bookmarks has: ".$result->rowCount." entries (should be 2)<br/>");
var_dump($result->rows);
/**********************************************/
