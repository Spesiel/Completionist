<?php namespace Completionistv2;

use \InvalidArgumentException;

use \PDO;

class Database
{
    const TABLES = array(
        "users" => array("name","email","hash"),
        "games" => array("name","link","comment","userid")
    );

    public static function select($table = "", $columns = array("*"), $filters = array())
    {
        // Some verifications on arguments
        static::checkArguments("select", $table, $columns, array(), $filters);

        $query = "SELECT ".implode(",", $columns)
            ." FROM $table"
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    public static function insert($table = "", $columns = array(), $values = array())
    {
        static::checkArguments("insert", $table, $columns, $values, array());

        $query = "INSERT INTO $table "
            ."(".implode(",", $columns).") "
            ."VALUES "
            ."('".implode("','", $values)."')";

        return static::execute($query);
    }

    public static function update($table = "", $columns = array(), $values = array(), $filters = array())
    {
        static::checkArguments("update", $table, $columns, $values, $filters);

        $query = "UPDATE $table SET ";
        $args = array();
        while (count($columns)) {
            $col = array_pop($columns);
            $val = array_pop($values);
            $args[] = $col."='$val'";
        }
        $query .= implode(",", $args)
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    public static function delete($table = "", $filters = array())
    {
        static::checkArguments("delete", $table, $columns, $values, $filters);

        $query = "DELETE FROM $table WHERE "
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    private static function checkArguments($caller, $table, $columns, $values, $filters)
    {
        // Some verifications on arguments
        if (empty($table)) {
            throw new InvalidArgumentException("=== $caller: \$table cannot be empty");
        }
        if (empty(self::TABLES[$table])) {
            throw new InvalidArgumentException("=== $caller: \$table unknown: $table");
        }
        if (!is_array($columns)) {
            throw new InvalidArgumentException("=== $caller: \$columns: expected array, got ".gettype($columns));
        }
        if (!count($columns)) {
            throw new InvalidArgumentException("=== $caller: \$columns cannot be empty");
        }
        if (!is_array($values)) {
            throw new InvalidArgumentException("=== $caller: \$columns: expected array, got ".gettype($columns));
        }
        if (!substr_compare($caller, "SELECT", 0) && !count($values)) {
            throw new InvalidArgumentException("=== $caller: \$values cannot be empty");
        }
        if (!is_array($filters)) {
            throw new InvalidArgumentException("=== $caller: \$filters: expected array, got ".gettype($filters));
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
            new CompletionistException($e->getMessage()." === Query: $query");
        }

        return $result;
    }

    public static function encodeString($value)
    {
        return strtr(rawurlencode($value), array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'));
    }
}
