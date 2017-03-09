<?php namespace Completionist\Tests\Units;

use \PDO;

const TABLES = array(
    "bookmarks" => false,
    "completion"=> true,
    "friends"   => true,
    "messages"  => true,
    "sessions"  => true,
    "games"     => true,
    "users"     => true
);

<<<<<<< HEAD:.tests/reset.php
foreach (TABLES as $key => $value) {
    plop("SET foreign_key_checks = 0; TRUNCATE TABLE $key; SET foreign_key_checks = 1;", $key);
=======
function dbExecute($query, $key)
{
    require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";
>>>>>>> develop:.tests/Units/resetFunctions.php

    $result = false;

    $connection = new PDO(
        "mysql:host=localhost;dbname=completionist;charset=utf8mb4",
        "completionist",
        "default",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );

    try {
        $connection->beginTransaction();
        $statement = $connection->prepare($query);
        $result = $statement->execute();
        $connection->commit();
    } catch (\PDOException $e) {
        $connection->rollBack();
        new CompletionistException($e->getMessage());
    }

    return $result;
}
