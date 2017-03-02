<?php namespace Completionist;

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
