<?php namespace Completionist\Tests;

use \PDO;

function dbExecute($query, $key)
{
    require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";

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
