<?php namespace Completionist\Dao;

use Completionist\Constants\Tables as Tables;

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
        return Database::select(Tables::COMPLETION, $columns, $filters);
    }

    public static function insert($userid, $gameid, $status = null, $comment = null)
    {
        return Database::insert(
            Tables::COMPLETION,
            Database::TABLES[Tables::COMPLETION],
            array($userid, $gameid, $status, Database::encodeString($comment))
        );
    }

    public static function update($userid, $gameid, $status = null, $comment = null)
    {
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

        return Database::update(Tables::COMPLETION, $columns, $values, array("userid=$userid", "gameid=$gameid"));
    }
}
