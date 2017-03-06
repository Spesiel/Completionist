<?php namespace Completionist\Dao;

use \InvalidArgumentException;
use \PDO;

use Completionist\Config as Config;
use Completionist\Constants\Keywords as Keywords;
use Completionist\Constants\Tables as Tables;
use Completionist\CompletionistException as CompletionistException;

class Database
{
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
            if (!Keywords::exists($val)) {
                $args[] = $col."='$val'";
            } else {
                $args[] = $col."=$val";
            }
        }
        $query .= implode(",", $args)
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    public static function delete($table = "", $filters = array())
    {
        static::checkArguments("delete", $table, array("userid","gameid"), array("userid","gameid"), $filters);

        $query = "DELETE FROM $table"
            .(!empty($filters)?" WHERE ".implode(" AND ", $filters):"");

        return static::execute($query);
    }

    private static function checkArguments($caller, $table, $columns, $values, $filters)
    {
        // Some verifications on arguments
        if (empty($table)) {
            throw new InvalidArgumentException("=== $caller: \$table cannot be empty");
        }
        if (!Tables::exists($table)) {
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
        $connection = new PDO(
            Config::DBCONNECTION,
            Config::DBUSERNAME,
            Config::DBPASSWORD,
            Config::PDOOPTIONS
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
