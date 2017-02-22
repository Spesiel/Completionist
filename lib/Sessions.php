<?php namespace Completionistv2;

use \DateTime;
use \DateInterval;

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
                // Setting new expiration date
                $result = self::updateExpiration($check->rows[0]->token);
            } else {
                // Creates token
                $payload = array(
                    "exp"   => self::getExpirationDate(),
                    "name"  => $user->rows[0]->name
                );
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
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";

        $result = Database::select("sessions", array("*"), array("active=1", "token='$token'"));
        if ($result->rowCount==1) {
            $token = TokenHelper::decode($result->rows[0]->token);
            // Check token for expiration date, and close session if need be.
            date_default_timezone_set('UTC');
            if (!(DateTime::createFromFormat("Ymd", $token->exp) > new DateTime())) {
                self::close($result->rows[0]->token);
                $result = null;
            }

            return $result;
        }
    }

    private static function getExpirationDate()
    {
        date_default_timezone_set('UTC');

        // Expiration date
        $expdate = new DateTime();
        $expdate->add(new DateInterval("P7D"));
        return $expdate->format("Ymd");
    }

    private static function updateExpiration($token)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\TokenHelper.php";

        // Updating token
        $token = TokenHelper::decode($token);
        $token->exp = self::getExpirationDate();
        $token = TokenHelper::encode($token);
        $result = Database::update("sessions", array("token"), array($token));
        $result->token = $token;

        return $result;
    }
}
