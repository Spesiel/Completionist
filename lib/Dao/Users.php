<?php namespace Completionist\Dao;

use Completionist\Helper\PasswordHelper as PasswordHelper;
use Completionist\Constants\Tables as Tables;
use Completionist\Constants\Roles as Roles;

class Users
{
    public static function select($columns = array("*"), $filters = array())
    {
        $result = Database::select(Tables::USERS, $columns, $filters);

        foreach ($result->rows as $row) {
            if (!empty($row->role)) {
                $row->role = Roles::ROLES[($row->role)];
            }
        }

        return $result;
    }

    public static function insert($name, $email, $hash)
    {
        if (empty($email)) {
            return Database::insert(
                Tables::USERS,
                array("name","hash"),
                array(Database::encodeString($name), $hash)
            );
        } else {
            return Database::insert(
                Tables::USERS,
                array("name","email","hash"),
                array(Database::encodeString($name),Database::encodeString($email), $hash)
            );
        }
    }

    public static function update($userid, $name, $email, $hash)
    {
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
        return Database::update(
            Tables::USERS,
            $columns,
            $values,
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    public static function activate($userid)
    {
        self::saveEntry($userid);
        return Database::update(
            Tables::USERS,
            array("active"),
            array(1),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    public static function deactivate($userid)
    {
        self::saveEntry($userid);
        return Database::update(
            Tables::USERS,
            array("active"),
            array(0),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    public static function getRole($userid)
    {
        $roles = Database::select(Tables::USERS, array("role"), array("userid=$userid","useridorigin=userid"));
        return Roles::ROLES[($roles->rows[0]->role)];
    }

    public static function setRole($userid, $role)
    {
        self::saveEntry($userid);
        return Database::update(
            Tables::USERS,
            array("role"),
            array((Roles::LISTING[$role])),
            array("userid=useridorigin", "useridorigin=$userid")
        );
    }

    private static function saveEntry($userid)
    {
        $result = Database::select(
            Tables::USERS,
            array("useridorigin","name","email","hash","modification","active","role"),
            array("userid=useridorigin", "useridorigin=$userid")
        );
        $result = json_decode(json_encode($result->rows[0]), true);
        Database::insert(
            Tables::USERS,
            array("useridorigin","name","email","hash","modification","active","role"),
            $result
        );
    }
}
