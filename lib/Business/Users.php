<?php namespace Completionist\Business;

use Completionist\Result as Result;
use Completionist\Helper\PasswordHelper as PasswordHelper;
use Completionist\Dao\Users as DUsers;

class Users
{
    // Requests the name see if it is available
    public static function checkName($name)
    {
        $select = DUsers::select(array("count(name) AS count"), array("name LIKE '$name'"));

        return new Result(intval($select->rows[0]->count));
    }

    public static function create($name, $email, $password)
    {
        $result = self::checkName($name);
        if ($result->result == 0) {
            $result = DUsers::insert($name, $email, PasswordHelper::encode($password));
            if ($result->rowCount == 1) {
                $result = new Result(true);
            }
        } else {
            $result = new Result(false);
        }

        return $result;
    }

    public static function update($id, $name, $email, $oldPassword, $newPassword)
    {
        $oldHash = DUsers::select(array("hash"), array("userid=useridorigin","useridorigin=$id"));
        $passwordCheck = PasswordHelper::Check(
            $oldPassword,
            $oldHash->rows[0]->hash
        );

        if ($passwordCheck) {
            $update = DUsers::update($id, $name, $email, PasswordHelper::encode($newPassword), $id);
            if ($update->rowCount == 1) {
                $result = new Result(true);
            }
        } else {
            $result = new Result(false);
            $result->errors[] = "Old password is wrong";
        }

        return $result;
    }

    public static function getRole($id)
    {
        return new Result(DUsers::getRole($id));
    }

    public static function setRole($id, $role, $modifier)
    {
        $modifierRole = self::getRole($modifier);
        if (self::isAdmin($modifier)) {
            $result = new Result(false);
            $result->errors[] = "Request denied";
        } else {
            $result = DUsers::setRole($id, $role, $modifier);
            $result = new Result($result->rowCount);
        }

        return $result;
    }

    public static function getStatus($id)
    {
        $select = DUsers::select(array("active"), array("userid=useridorigin","useridorigin=$id"));

        return new Result(($select->rows[0]->active)?true:false);
    }

    public static function enable($id, $modifier)
    {
        $modifierRole = self::getRole($modifier);
        if (self::isAdmin($modifier)) {
            $result = new Result(false);
            $result->errors[] = "Request denied";
        } else {
            $result = DUsers::activate($id, $modifier);
            $result = new Result($result->rowCount);
        }

        return $result;
    }

    public static function disable($id, $modifier)
    {
        if (self::isAdmin($modifier)) {
            $result = new Result(false);
            $result->errors[] = "Request denied";
        } else {
            $result = DUsers::deactivate($id, $modifier);
            $result = new Result($result->rowCount);
        }

        return $result;
    }

    private static function isAdmin($userid)
    {
        $result = self::getRole($userid);
        return ($result->result!=="admin");
    }
}
