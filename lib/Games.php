<?php namespace Completionist;

class Games
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::select("games", $columns, $filters);
    }

    public static function insert($name, $link, $comment, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::insert(
            "games",
            Database::TABLES["games"],
            array(Database::encodeString($name),Database::encodeString($link),Database::encodeString($comment),$userid)
        );
    }

    public static function update($gameid, $name, $link, $comment, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $columns = array();
        $values = array();

        if (!empty($name)) {
            $columns[] = "name";
            $values [] = Database::encodeString($name);
        }
        if (!empty($link)) {
            $columns[] = "link";
            $values [] = Database::encodeString($link);
        }
        if (!empty($comment)) {
            $columns[] = "comment";
            $values [] = Database::encodeString($comment);
        }
        $columns[] = "userid";
        $values[] = $userid;

        self::saveEntry($gameid);
        return Database::update("games", $columns, $values, array("gameid=gameidorigin", "gameidorigin=$gameid"));
    }

    public static function lock($gameid, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        self::saveEntry($gameid);
        return Database::update(
            "games",
            array("locked","userid"),
            array(1,$userid),
            array("gameid=gameidorigin", "gameid = $gameid")
        );
    }

    public static function unlock($gameid, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        self::saveEntry($gameid);
        return Database::update(
            "games",
            array("locked","userid"),
            array(0,$userid),
            array("gameid=gameidorigin", "gameid = $gameid")
        );
    }

    private static function saveEntry($gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result = Database::select(
            "games",
            array("gameidorigin","name","link","comment","modification","userid","locked"),
            array("gameid=gameidorigin", "gameidorigin=$gameid")
        );
        $result = json_decode(json_encode($result->rows[0]), true);
        Database::insert(
            "games",
            array("gameidorigin","name","link","comment","modification","userid","locked"),
            $result
        );
    }
}
