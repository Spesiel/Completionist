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
printf("Password checks hash: $compare (should be 1)<br/>");
$compare = PasswordHelper::check("wrong password", $hash);
printf("Password checks hash: ".(!$compare?"null":"1")." (should be null)<br/>");
/**********************************************/

/***********************************************
* Tests on tokenHelper
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";
printf("<h1>TokenHelper</h1><hr/>");

printf("Payload: name is test");
$payload = array("name"=>"test");
var_dump($payload);
printf("Payload: token value");
$token = TokenHelper::encode($payload);
var_dump($token);
printf("Payload: token decoded");
$newPayload = TokenHelper::decode($token);
var_dump($newPayload);
printf("Different payload: name is test2");
$diffPayload = TokenHelper::decode(
    "eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdDIifQ.4aWmIAbncNwvL31_Pml8wjr1DO44Bpoi0g4APrHxMxY"
);
var_dump($diffPayload);
/**********************************************/

/***********************************************
* Tests on users select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";
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

/***********************************************
* Tests on games select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Games.php";
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

/***********************************************
* Tests on bookmarks add/delete
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Bookmarks.php";
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

/***********************************************
* Tests on sessions select/insert/update
***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Sessions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";
printf("<h1>Sessions select/insert/update</h1><hr/>");

$result = Sessions::select();
printf("Sessions has: ".$result->rowCount." entries<br/>");
var_dump($result->rows);

$result = Sessions::open("test1", "testhash1");
printf("Sessions: ".$result->rowCount." row affected (should be 1)<br/>");
var_dump($result);

printf("Payload: token decoded");
var_dump(TokenHelper::decode($result->token));
$token = $result->token;

$result = Sessions::select();
printf("Sessions has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Sessions::check($token);
printf("Sessions: user is logged in<br/>");
var_dump($result);

$result = Sessions::check("dummy");
printf("Sessions: user is not logged in, and returned null<br/>");
var_dump($result);

sleep(2);

$result = Sessions::open("test1", "testhash");
printf("Sessions: wrong login, and returned null<br/>");
var_dump($result);

$result = Sessions::close($token);
printf("Sessions: ".$result->rowCount." row affected (should be 1)<br/>");

$result = Sessions::select();
printf("Sessions has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

$result = Sessions::check($token);
printf("Sessions: user is not logged in, and returned null<br/>");
var_dump($result);
/**********************************************/

printf("<hr/><hr/><h1>Reset</h1><hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/reset.php";
