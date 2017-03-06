<?php namespace Completionist\Dao;

use Completionist\Constants\Tables as Tables;

class Bookmarks
{
    public static function select($columns = array("*"), $filters = array())
    {
        return Database::select(Tables::BOOKMARKS, $columns, $filters);
    }

    public static function add($userid, $gameid)
    {
        return Database::insert(
            Tables::BOOKMARKS,
            array("userid","gameid"),
            array($userid,$gameid)
        );
    }

    public static function remove($userid, $gameid)
    {
        return Database::delete(
            Tables::BOOKMARKS,
            array("userid=$userid","gameid=$gameid")
        );
    }
}
