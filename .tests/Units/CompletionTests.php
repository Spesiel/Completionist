<?php namespace Completionist\Tests\Units;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Games.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Completion.php";

use Completionist\Tests\Functions as Tests;
use Completionist\Dao\Games as Games;
use Completionist\Dao\Completion as Completion;

/***********************************************
* Adding users
***********************************************/
$list = array();

$result = Completion::select();
$list[] = array(
    "Completion should be empty",
    0,
    $result->rowCount
);

$result = Completion::set(1, 8, "started");
$list[] = array(
    "Completion for userid=1 gameid=8: started",
    1,
    $result->rowCount
);

$result = Completion::select();
$list[] = array(
    "Completion has 1 value",
    1,
    $result->rowCount
);
$list[] = array(
    "Completion status: started",
    "started",
    $result->rows[0]->status
);

$result = Completion::set(1, 8, "completed");
$list[] = array(
    "Completion for userid=1 gameid=8: completed",
    1,
    $result->rowCount
);

$result = Completion::select();
$list[] = array(
    "Completion has 1 value",
    1,
    $result->rowCount
);
$list[] = array(
    "Completion status: completed",
    "completed",
    $result->rows[0]->status
);
/**********************************************/

Tests::run("Completion", $list);
