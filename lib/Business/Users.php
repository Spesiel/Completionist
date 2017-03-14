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
            $update = DUsers::update($id, $name, $email, PasswordHelper::encode($newPassword));
            if ($update->rowCount == 1) {
                $result = new Result(true);
            }
        } else {
            $result = new Result(false);
            $result->errors[] = "Old password is wrong";
        }

        return $result;
    }

    /* TODO */
    // activate/deactivate/getrole/setrole
}
