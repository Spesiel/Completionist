<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Sessions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\TokenHelper.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Sessions as Sessions;
use Completionist\Helper\TokenHelper as TokenHelper;

/***********************************************
* Tests on sessions select/insert/update
***********************************************/
$list = array();

$result = Sessions::select();
$list[] = array(
    "Sessions should be empty",
    0,
    $result->rowCount
);

$result = Sessions::open("test1", "testhash1");
$list[] = array(
    "Sessions has 1 entry",
    1,
    $result->rowCount
);

$tokenDecoded = TokenHelper::decode($result->token);
$expected = new \stdclass;
        // Expiration date
        date_default_timezone_set('UTC');
        $expdate = new \DateTime();
        $expdate->add(new \DateInterval("P7D"));
$expected->exp = $expdate->format("Ymd");
$expected->name = "test1";
$expected->role = "user";
$list[] = array(
    "Payload: token decoded",
    serialize($expected),
    serialize($tokenDecoded)
);
$token = $result->token;

$result = Sessions::select();
$list[] = array(
    "Sessions has 1 entry",
    1,
    $result->rowCount
);

$result = Sessions::check($token);
$list[] = array(
    "Sessions: user is logged in",
    1,
    $result->rowCount
);

$result = Sessions::check("dummy");
$list[] = array(
    "Sessions: user is not logged in, and returned null",
    null,
    $result
);

$result = Sessions::open("test1", "testhash1");
$list[] = array(
    "Session is already opened",
    0,
    $result->rowCount
);

$result = Sessions::select();
$list[] = array(
    "Sessions has 1 entry",
    1,
    $result->rowCount
);
sleep(2);

$result = Sessions::open("test1", "testhash");
$list[] = array(
    "Sessions: wrong login, and returned null",
    null,
    $result
);

$result = Sessions::close($token);
$list[] = array(
    "Sessions: closed",
    1,
    $result->rowCount
);

$result = Sessions::select();
$list[] = array(
    "Sessions has 1 entry",
    1,
    $result->rowCount
);

$result = Sessions::check($token);
$list[] = array(
    "Sessions: user is not logged in",
    null,
    $result
);
/**********************************************/

Tests::run("Sessions", $list);
