<?php namespace Completionist\Tests\Units;

printf("<hr/><hr/><h1>Reset ");

use Completionist\Tests\Functions as Tests;

$list = array();

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/resetFunctions.php";

foreach (TABLES as $key => $value) {
    $list[] = array(
        true,
        dbExecute("SET foreign_key_checks = 0; TRUNCATE TABLE $key; SET foreign_key_checks = 1;", $key)
    );

    if ($value===true) {
        $list[] = array(
            true,
            dbExecute("ALTER TABLE $key auto_increment = 1;", $key)
        );
    }
}

Tests::assertions($list, false);
printf("</h1>");
