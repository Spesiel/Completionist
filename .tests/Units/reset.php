<?php namespace Completionist\Tests\Units;

use Completionist\Tests\Functions as Tests;

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/resetFunctions.php";


$list = array();
foreach (TABLES as $key => $value) {
    $list[] = array(
        "Truncate table $key",
        true,
        dbExecute("SET foreign_key_checks = 0; TRUNCATE TABLE $key; SET foreign_key_checks = 1;", $key)
    );

    if ($value===true) {
        $list[] = array(
            "Reset auto_increment on table $key",
            true,
            dbExecute("ALTER TABLE $key auto_increment = 1;", $key)
        );
    }
}

Tests::run("Reset", $list);
