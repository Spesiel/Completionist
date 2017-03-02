<?php namespace Completionist;

class Users
{
    const ROLES = array(
        127 => "admin",
         63 => "poweruser",
          1 => "user"
    );

    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result = Database::select("users", $columns, $filters);

        foreach ($result->rows as $row) {
            $row->role = self::ROLES[($row->role)];
        }

        return $result;
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
            $values [] = Database::encodeString($email);
        }
        if (!empty($hash)) {
            $columns[] = "hash";
            $values [] = $hash;
        }

        self::saveEntry($userid);
        return Database::update("users", $columns, $values, array("userid=useridorigin", "useridorigin=$userid"));
    }

    public static function activate($userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        self::saveEntry($userid);
        return Database::update(
            "users",
            array("active"),
            array(1),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    public static function deactivate($userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        self::saveEntry($userid);
        return Database::update(
            "users",
            array("active"),
            array(0),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    public static function getRole($userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $roles = Database::select("users", array("role"), array("userid=$userid","useridorigin=userid"));
        return self::ROLES[($roles->rows[0]->role)];
    }

    public static function setRole($userid, $role)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        self::saveEntry($userid);
        return Database::update(
            "users",
            array("role"),
            array(array_search($role, self::ROLES)),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    private static function saveEntry($userid)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result = Database::select(
            "users",
            array("useridorigin","name","email","hash","modification","active","role"),
            array("userid=useridorigin", "useridorigin=$userid")
        );
        $result = json_decode(json_encode($result->rows[0]), true);
        Database::insert("users", array("useridorigin","name","email","hash","modification","active","role"), $result);
    }
}
