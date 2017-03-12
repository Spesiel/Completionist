<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\TokenHelper.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Helper\TokenHelper as TokenHelper;

/***********************************************
* Tests on tokenHelper
***********************************************/
$payload = array("name"=>"test");

$list = array();
$list[] = array(
    "Token generation",
    "eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdCJ9.DyaQB3sgUFEMyGAaNTHVDe_yrdOGARAY4TtInYvSv0g",
    TokenHelper::encode($payload)
);
$result = TokenHelper::decode(
    "eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdCJ9.DyaQB3sgUFEMyGAaNTHVDe_yrdOGARAY4TtInYvSv0g"
);
$list[] = array(
    "Token decoding 1",
    "test",
    $result->name
);
$result = TokenHelper::decode(
    "eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidGVzdDIifQ.4aWmIAbncNwvL31_Pml8wjr1DO44Bpoi0g4APrHxMxY"
);
$list[] = array(
    "Token decoding 2",
    "test2",
    $result->name
);
/**********************************************/

Tests::run("TokenHelper", $list);
