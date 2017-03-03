<?php namespace Completionist\Dao;

class Friends
{
    const STATUS = array(
         127 => "accepted",
          63 => "requested",
         -63 => "blocked"
    );

    protected function __construct()
    {
        spl_autoload_register(function ($classname) {
            require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\Dao\\".$classname.".php";
        });
    }

    public static function select($columns = array("*"), $filters = array())
    {
        $result = Database::select("friends", $columns, $filters);

        foreach ($result->rows as $row) {
            $row->status = self::STATUS[($row->status)];
        }

        return $result;
    }

    public static function getRequests($userid)
    {
        return self::select(
            array("*"),
            array("friendid=$userid","status=".array_search("requested", self::STATUS))
        );
    }

    public static function getList($userid)
    {
        $result1 = self::select(array("*"), array("userid=$userid","status=".array_search("accepted", self::STATUS)));
        $result2 = self::select(array("*"), array("friendid=$userid","status=".array_search("accepted", self::STATUS)));

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
        $isBlocked1 = self::select(
            array("*"),
            array("userid=$friendid","friendid=$userid",array_search("blocked", self::STATUS))
        );
        $isBlocked2 = self::select(
            array("*"),
            array("userid=$userid","friendid=$friendid",array_search("blocked", self::STATUS))
        );
        $isBlocked = $isBlocked1->rowCount + $isBlocked2->rowCount;

        if ($isBlocked > 0) {
            $result = new \stdclass;
            $result->rowCount = 0;
            return $result;
        } else {
            return Database::insert(
                "friends",
                array("userid","friendid","status"),
                array($userid,$friendid,array_search("requested", self::STATUS))
            );
        }
    }

    public static function accept($userid, $friendid)
    {
        return Database::update(
            "friends",
            array("status"),
            array(array_search("accepted", self::STATUS)),
            array("userid=$friendid","friendid=$userid")
        );
    }

    public static function block($userid, $friendid)
    {
        self::remove($userid, $friendid);
        self::remove($friendid, $userid);

        return Database::insert(
            "friends",
            array("userid","friendid","status"),
            array($userid,$friendid,array_search("blocked", self::STATUS))
        );
    }

    public static function remove($userid, $friendid)
    {
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
