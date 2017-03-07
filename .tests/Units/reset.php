<?php namespace Completionist\Tests\Units;

const TABLES = array(
    "bookmarks" => false,
    "friends"   => true,
    "messages"  => true,
    "sessions"  => true,
    "games"     => true,
    "users"     => true
);

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\.tests\Units\resetFunctions.php";

foreach (TABLES as $key => $value) {
    dbExecute("SET foreign_key_checks = 0; TRUNCATE TABLE $key; SET foreign_key_checks = 1;", $key);

    if ($value===true) {
        dbExecute("ALTER TABLE $key auto_increment = 1;", $key);
    }
}
