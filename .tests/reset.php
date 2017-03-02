<?php namespace Completionist\Tests;

use \PDO;

const TABLES = array(
    "bookmarks" => false,
    "friends"   => true,
    "messages"  => true,
    "sessions"  => true,
    "games"     => true,
    "users"     => true
);

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";

foreach (TABLES as $key => $value) {
    plop("SET foreign_key_checks = 0; TRUNCATE TABLE $key; SET foreign_key_checks = 1;", $key);

    if ($value===true) {
        plop("ALTER TABLE $key auto_increment = 1;", $key);
    }
}

function plop($query, $key)
{
    $connection = new PDO(
        "mysql:host=localhost;dbname=completionist;charset=utf8mb4",
        "completionist",
        "default",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );

    try {
        printf("<hr/>$query:");
        $connection->beginTransaction();
        $statement = $connection->prepare($query);
        $result = $statement->execute();
        var_dump($result);
        $connection->commit();
    } catch (\PDOException $e) {
        $connection->rollBack();
        new CompletionistException($e->getMessage());
    }
}
