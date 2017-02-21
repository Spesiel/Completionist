<?php namespace Completionistv2;

class Sessions
{
    public static function select($columns = array("*"), $filters = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        return Database::select("sessions", $columns, $filters);
    }

    public static function open($name, $password)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\PasswordHelper.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";

        $hash = PasswordHelper::encode($password);
        $user = Users::select(
            array("useridorigin as userid,name,hash"),
            array("userid=useridorigin","active=1","name='$name'")
        );

        // User found and matched
        if ($user->rowCount==1 && PasswordHelper::check($password, $user->rows[0]->hash)) {
            $check = self::select(array("token"), array("userid=".$user->rows[0]->userid,"active=1"));

            // There's already a session opened for that user
            if ($check->rowCount==1) {
                $result = new \stdclass;
                $result->rowCount = 0;
                $result->token = $check->rows[0]->token;
            } else {
                // Creates token
                $payload = array("name"=>$user->rows[0]->name);
                $token = TokenHelper::encode($payload);

                $result = Database::insert("sessions", array("token","userid"), array($token, $user->rows[0]->userid));
                $result->token = $token;
            }

            return $result;
        }
    }

    public static function close($token)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result = Database::select("sessions", array("*"), array("token='$token'"));
        if ($result->rowCount==1) {
            return Database::update("sessions", array("active"), array(0));
        }
    }

    public static function check($token)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

        $result = Database::select("sessions", array("*"), array("active=1", "token='$token'"));
        if ($result->rowCount==1) {
            return $result;
        }
    }
}
