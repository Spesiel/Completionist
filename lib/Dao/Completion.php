<?php namespace Completionist\Dao;

class Completion
{
    const STATUS = array(
         127 => "completed",
           1 => "started",
          -1 => "abandoned",
        -128 => "failed"
    );

    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::select("completion", $columns, $filters);
    }

    public static function insert($userid, $gameid, $status = null, $comment = null)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::insert(
            "completion",
            Database::TABLES["completion"],
            array($userid, $gameid, $status, Database::encodeString($comment))
        );
    }

    public static function update($userid, $gameid, $status = null, $comment = null)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        $columns = array();
        $values = array();

        if (!empty($status)) {
            $columns[] = "status";
            $values [] = $status;
        }

        if (!empty($comment)) {
            $columns[] = "comment";
            $values [] = Database::encodeString($comment);
        }

        return Database::update("completion", $columns, $values, array("userid=$userid", "gameid=$gameid"));
    }
}
