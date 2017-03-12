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
        $result = Database::select(Tables::COMPLETION, $columns, $filters);

        foreach ($result->rows as $row) {
            $row->status = self::STATUS[$row->status];
        }
        return $result;
    }

    public static function set($userid, $gameid, $status = null, $comment = null)
    {
        $result = self::select(array("*"), array("userid=$userid", "gameid=$gameid"));

        if ($status) {
            $status = array_search($status, self::STATUS);
        }

        switch ($result->rowCount) {
            case 0:
                return self::insert($userid, $gameid, $status, $comment);
            default:
                return self::update($userid, $gameid, $status, $comment);
        }
    }

    private static function insert($userid, $gameid, $status = null, $comment = null)
    {
        return Database::insert(
            Tables::COMPLETION,
            Tables::LISTING[Tables::COMPLETION],
            array($userid, $gameid, $status, Database::encodeString($comment))
        );
    }

    private static function update($userid, $gameid, $status = null, $comment = null)
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
