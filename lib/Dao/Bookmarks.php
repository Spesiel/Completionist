<?php namespace Completionist\Dao;

class Bookmarks
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::select("bookmarks", $columns, $filters);
    }

    public static function add($userid, $gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::insert(
            "bookmarks",
            array("userid","gameid"),
            array($userid,$gameid)
        );
    }

    public static function remove($userid, $gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::delete(
            "bookmarks",
            array("userid=$userid","gameid=$gameid")
        );
    }
}
