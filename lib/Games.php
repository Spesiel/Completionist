<?php namespace Completionistv2;

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
            $values [] = Databse::encodeString($link);
        }
        if (!empty($comment)) {
            $columns[] = "comment";
            $values [] = Databse::encodeString($comment);
        }
        $columns[] = "userid";
        $values[] = $userid;

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

        return Database::update("games", $columns, $values, array("gameid=gameidorigin", "gameidorigin=$gameid"));
    }

    public static function lock($gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        return Database::update("games", array("locked"), array(1), array("gameid=gameidorigin", "gameid = '$gameid'"));
    }

    public static function unlock($gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        return Database::update("games", array("locked"), array(0), array("gameid=gameidorigin", "gameid = '$gameid'"));
    }
}
