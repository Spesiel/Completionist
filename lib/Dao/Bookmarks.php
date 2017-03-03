<?php namespace Completionist\Dao;

class Bookmarks
{
    protected function __construct()
    {
        spl_autoload_register(function ($classname) {
            require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\Dao\\".$classname.".php";
        });
    }

    public static function select($columns = array("*"), $filters = array())
    {
        return Database::select("bookmarks", $columns, $filters);
    }

    public static function add($userid, $gameid)
    {
        return Database::insert(
            "bookmarks",
            array("userid","gameid"),
            array($userid,$gameid)
        );
    }

    public static function remove($userid, $gameid)
    {
        return Database::delete(
            "bookmarks",
            array("userid=$userid","gameid=$gameid")
        );
    }
}
