<?php namespace Completionistv2;

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

$result = Sessions::open("test1", "testhash1");
printf("Sessions: ".$result->rowCount." row affected (should be 0), session is already opened<br/>");
var_dump($result);

printf("Payload: token decoded");
var_dump(TokenHelper::decode($result->token));
$token = $result->token;

$result = Sessions::select();
printf("Sessions has: ".$result->rowCount." entries (should be 1)<br/>");
var_dump($result->rows);

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
