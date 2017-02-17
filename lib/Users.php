<?php namespace Completionistv2;

class Users
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::select("users", $columns, $filters);
    }

    public static function insert($name, $email, $password)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\PasswordHelper.php";
        $hash = PasswordHelper::encode($password);

        if (empty($email)) {
            return Database::insert("users", array("name","hash"), array(Database::encodeString($name), $hash));
        } else {
            return Database::insert(
                "users",
                array("name","email","hash"),
                array(Database::encodeString($name),Database::encodeString($email), $hash)
            );
        }
    }

    public static function update($userid, $name, $email, $password)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\PasswordHelper.php";
        $hash = PasswordHelper::encode($password);

        $columns = array();
        $values = array();

        if (!empty($name)) {
            $columns[] = "name";
            $values [] = Database::encodeString($name);
        }
        if (!empty($email)) {
            $columns[] = "email";
            $values [] = Databse::encodeString($email);
        }
        if (!empty($hash)) {
            $columns[] = "hash";
            $values [] = $hash;
        }

        $result = Database::select(
            "users",
            array("useridorigin","name","email","hash","modification","active"),
            array("userid=useridorigin", "useridorigin=$userid")
        );
        $result = json_decode(json_encode($result->rows[0]), true);
        Database::insert("users", array("useridorigin","name","email","hash","modification","active"), $result);

        return Database::update("users", $columns, $values, array("userid=useridorigin", "useridorigin=$userid"));
    }

    public static function activate($name)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        return Database::update("users", array("active"), array(1), array("name = '$name'"));
    }

    public static function deactivate($name)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        return Database::update("users", array("active"), array(0), array("name = '$name'"));
    }
}
