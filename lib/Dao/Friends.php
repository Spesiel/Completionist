<?php namespace Completionist\Dao;

class Friends
{
    const STATUS = array(
        127 => "accepted",
         63 => "requested",
          1 => "blocked"
    );

    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        $result = Database::select("friends", $columns, $filters);

        foreach ($result->rows as $row) {
            $row->status = self::STATUS[($row->status)];
        }

        return $result;
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
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::insert(
            "friends",
            array("userid","friendid","status"),
            array($userid,$friendid,array_search("requested", self::STATUS))
        );
    }

    public static function accept($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::update(
            "friends",
            array("status"),
            array(array_search("accepted", self::STATUS)),
            array("userid=$friendid","friendid=$userid")
        );
    }

    public static function block($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::update(
            "friends",
            array("status"),
            array(array_search("blocked", self::STATUS)),
            array("userid=$userid","friendid=$friendid")
        );
    }

    public static function remove($userid, $friendid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

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
