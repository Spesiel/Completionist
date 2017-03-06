<?php namespace Completionist\Dao;

use Completionist\Constants\Keywords as Keywords;
use Completionist\Constants\Tables as Tables;

class Messages
{
    public static function select($columns = array("*"), $filters = array())
    {
        return Database::select(Tables::MESSAGES, $columns, $filters);
    }

    public static function getAll($userid)
    {
        $result1 = self::select(array("*"), array("touserid=$userid"));
        $result2 = self::select(array("*"), array("fromuserid=$userid"));

        $result = new \stdclass;
        $result->rowCount = $result1->rowCount+$result2->rowCount;
        $result->rows = array_merge($result1->rows, $result2->rows);

        return $result;
    }

    public static function send($from, $to, $title, $body)
    {
        return Database::insert(
            Tables::MESSAGES,
            array("fromuserid","touserid","title","body"),
            array($from,$to,$title,$body)
        );
    }

    public static function open($userid, $messageid)
    {
        Database::update(
            Tables::MESSAGES,
            array("opened"),
            array(Keywords::DBTIMESTAMP),
            array("touserid=$userid","messageid=$messageid")
        );

        return self::select(array("*"), array("touserid=$userid","messageid=$messageid"));
    }

    public static function delete($userid, $messageid)
    {
        return Database::update(
            Tables::MESSAGES,
            array("deleted"),
            array(Keywords::DBTIMESTAMP),
            array("touserid=$userid","messageid=$messageid")
        );
    }
}
