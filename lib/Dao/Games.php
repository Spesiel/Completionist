<?php namespace Completionist\Dao;

class Games
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::select("games", $columns, $filters);
    }

    public static function getTree($gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        $result = new \stdclass;

        return self::recurseTree(array($gameid));
    }

    public static function insert($name, $link, $comment, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        return Database::insert(
            "games",
            Database::TABLES["games"],
            array(Database::encodeString($name),Database::encodeString($link),Database::encodeString($comment),$userid)
        );
    }

    public static function insertSub($gameid, $name, $link, $comment, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        $cols = Database::TABLES["games"];
        $cols[] = "gameidrelated";
        $vals = array(
            Database::encodeString($name),
            Database::encodeString($link),
            Database::encodeString($comment),
            $userid,
            $gameid
        );

        return Database::insert("games", $cols, $vals);
    }

    public static function update($gameid, $name, $link, $comment, $userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

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
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

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
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        self::saveEntry($gameid);
        return Database::update(
            "games",
            array("locked","userid"),
            array(0,$userid),
            array("gameid=gameidorigin", "gameid = $gameid")
        );
    }

    private static function recurseTree($gameids = array())
    {
        $select = Database::select(
            "games",
            array("gameidorigin"),
            array(
                "gameid=gameidorigin",
                "gameidrelated IN (".implode(",", $gameids).")",
                "gameidorigin NOT IN (".implode(",", $gameids).")"
            )
        );

        $result = new \stdclass;
        $result->leaf = null;
        // Something was returned, getting the rest of the tree
        if ($select->rowCount != 0) {
            $result->leaf = array();
            foreach ($select->rows as $row) {
                $recurse = self::recurseTree(array($row->gameidorigin));
                if (!($recurse instanceof \stdclass)) {
                    foreach ($recurse as $array) {
                        $result->leaf[] = $array;
                    }
                } else {
                    $result->leaf[] = $recurse;
                }
            }
        }
        $select = Database::select(
            "games",
            array("*"),
            array(
                "gameid=gameidorigin",
                "gameidorigin IN (".implode(",", $gameids).")"
            )
        );
        if ($result->leaf==null) {
            $result = $select->rows;
        } else {
            $result->branch = $select->rows[0];
        }
        return $result;
    }

    private static function saveEntry($gameid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

        $result = Database::select(
            "games",
            array("gameidorigin","gameidrelated","name","link","comment","modification","userid","locked"),
            array("gameid=gameidorigin", "gameidorigin=$gameid")
        );
        $result = json_decode(json_encode($result->rows[0]), true);
        Database::insert(
            "games",
            array("gameidorigin","gameidrelated","name","link","comment","modification","userid","locked"),
            $result
        );
    }
}
