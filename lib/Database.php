<?php
namespace Completionistv2;

use \InvalidArgumentException;

use \PDO;

class Database
{
    private static $tables = array(
        "users" => array("name","email","hash")
    );

    public static function select($table = "", $columns = array("*"), $filters = array())
    {
        // Some verifications on arguments
        static::checkArguments("select", $table, $columns, $filters);

        $query = "SELECT ".implode(",", $columns)
            ." FROM ".$table
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    public static function insertUser($name, $email, $hash)
    {
        return static::insert("users", static::$tables["users"], array($name, $email, $hash));
    }

    private static function insert($table = "", $columns = array(), $values = array())
    {
        static::checkArguments("insert", $table, $columns, $values);

        $query = "INSERT INTO ".$table." "
            ."(".implode(",", $columns).") "
            ."VALUES "
            ."('";
        while (count($values)) {
            $val = array_pop($values);
            $args[] = static::encodeString($val);
        }
        $args = array_reverse($args);
        $query .= implode("','", $args)."')";

        return static::execute($query);
    }

    public static function updateUser($name, $email, $hash)
    {
        return static::update("users", static::$tables["users"], array($name, $email, $hash));
    }

    private static function update($table = "", $columns = array(), $values = array())
    {
        static::checkArguments("update", $table, $columns, $values);

        $query = "UPDATE ".$table." SET ";
        $args = array();
        while (count($columns)) {
            $col = array_pop($columns);
            $val = array_pop($values);
            $args[] = $col."='".static::encodeString($val)."'";
        }
        $query .= implode(",", $args);

        return static::execute($query);
    }

    private static function checkArguments($caller, $table, $columns, $values)
    {
        // Some verifications on arguments
        if (empty($table)) {
            throw new InvalidArgumentException("=== $caller: \$table cannot be empty");
        }
        if (empty(static::$tables[$table])) {
            throw new InvalidArgumentException("=== $caller: \$table unknown: $table");
        }
        if (!is_array($columns)) {
            throw new InvalidArgumentException("=== $caller: \$columns: expected array, got ".gettype($columns));
        }
        if (!count($columns)) {
            throw new InvalidArgumentException("=== $caller: \$columns cannot be empty");
        }
        if ($caller!=="select") {
            foreach ($columns as $col) {
                if (!in_array($col, static::$tables[$table])) {
                    throw new InvalidArgumentException("=== $caller: column unknown in $table: $col");
                }
            }
            if (!is_array($values)) {
                throw new InvalidArgumentException("=== $caller: \$columns: expected array, got ".gettype($columns));
            }
            if (count($values) != count($columns)) {
                throw new InvalidArgumentException("=== $caller: \$columns and \$values must have the same count");
            }
        }
    }

    private static function execute($query)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/lib/CompletionistException.php";

        $connection = new PDO(
            "mysql:host=localhost;dbname=completionistv2;charset=utf8mb4",
            "completionistv2",
            "default",
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );

        $result = new \stdclass;

        try {
            $connection->beginTransaction();
            $statement = $connection->prepare($query);
            $statement->execute();
            if (substr($query, 0, 1)==="S") {
                $result->rows = $statement->fetchAll(PDO::FETCH_OBJ);
                $result->rowCount = count($result->rows);
            } else {
                $connection->commit();
                $result->rowCount = $statement->rowCount();
            }
        } catch (\PDOException $e) {
            $connection->rollBack();
            new CompletionistException($e->getMessage()." === Query: ".$query);
        }

        return $result;
    }

    private static function encodeString($value)
    {
        return strtr(rawurlencode($value), array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'));
    }
}
