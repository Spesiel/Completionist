<?php
namespace Completionistv2;

class Users
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::select("users", $columns, $filters);
    }

    public static function insert($name, $email, $hash)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        if (empty($email)) {
            return Database::insert("users", array("name","hash"), array($name, $hash));
        } else {
            return Database::insert("users", array("name","email","hash"), array($name, $email, $hash));
        }
    }

    public static function update($name, $email, $hash)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $columns = array();
        $values = array();

        if (!empty($name)) {
            $columns[] = "name";
            $values [] = $name;
        }
        if (!empty($email)) {
            $columns[] = "email";
            $values [] = $email;
        }
        if (!empty($hash)) {
            $columns[] = "hash";
            $values [] = $hash;
        }
        return Database::update("users", $columns, $values);
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
