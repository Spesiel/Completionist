<?php namespace Completionistv2;

class Friends
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::select("friends", $columns, $filters);
    }

    public static function getRequests($userid)
    {
        return self::select(array("*"), array("friendid=$userid"));
    }

    public static function getList($userid)
    {
        $result1 = self::select(array("*"), array("userid=$userid"));
        $result2 = self::select(array("*"), array("friendid=$userid"));

        $result = new \stdclass;
        $result->rowCount = $result1->rowCount+$result2->rowCount;
        $result->rows = array();

        foreach ($result1->rows as $value) {
            $row = new \stdclass;
            $row->friendid = $value->friendid;
            $row->status = $value->status;
            $row->date = $value->date;
            $result->rows[] = $row;
        }

        foreach ($result2->rows as $value) {
            $row = new \stdclass;
            $row->friendid = $value->userid;
            $row->status = $value->status;
            $row->date = $value->date;
            $result->rows[] = $row;
        }

        return $result;
    }

    public static function request($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::insert(
            "friends",
            array("userid","friendid"),
            array($userid,$friendid)
        );
    }

    public static function accept($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::update(
            "friends",
            array("status"),
            array(true),
            array("userid=$friendid","friendid=$userid")
        );
    }

    public static function remove($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result1 = Database::delete(
            "friends",
            array("userid=$userid","friendid=$friendid")
        );

        $result2 = Database::delete(
            "friends",
            array("userid=$friendid","friendid=$userid")
        );

        $result = new \stdclass;
        $result->rowCount = $result1->rowCount + $result2->rowCount;

        return $result;
    }
}
