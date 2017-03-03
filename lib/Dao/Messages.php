<?php namespace Completionist\Dao;

class Messages
{
    protected function __construct()
    {
        spl_autoload_register(function ($classname) {
            require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\Dao\\".$classname.".php";
        });
    }

    public static function select($columns = array("*"), $filters = array())
    {
        return Database::select("messages", $columns, $filters);
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
            "messages",
            array("fromuserid","touserid","title","body"),
            array($from,$to,$title,$body)
        );
    }

    public static function open($userid, $messageid)
    {
        Database::update(
            "messages",
            array("opened"),
            array("CURRENT_TIMESTAMP"),
            array("touserid=$userid","messageid=$messageid")
        );

        return self::select(array("*"), array("touserid=$userid","messageid=$messageid"));
    }

    public static function delete($userid, $messageid)
    {
        return Database::update(
            "messages",
            array("deleted"),
            array("CURRENT_TIMESTAMP"),
            array("touserid=$userid","messageid=$messageid")
        );
    }
}
