<?php namespace Completionist\Dao;

use \DateTime;
use \DateInterval;
use \Completionist\Helper\PasswordHelper as PasswordHelper;
use \Completionist\Helper\TokenHelper as TokenHelper;

class Sessions
{
    protected function __construct()
    {
        spl_autoload_register(function ($classname) {
            if (substr($classname, -strlen("Helper"))==="Helper") {
                require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\Helper\\".$classname.".php";
            } else {
                require_once $_SERVER["DOCUMENT_ROOT"]."\\lib\\Dao\\".$classname.".php";
            }
        });
    }

    public static function select($columns = array("*"), $filters = array())
    {
        return Database::select("sessions", $columns, $filters);
    }

    public static function open($name, $password)
    {
        $hash = PasswordHelper::encode($password);
        $user = Users::select(
            array("useridorigin as userid,name,hash,role"),
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
                    "name"  => $user->rows[0]->name,
                    "role"  => $user->rows[0]->role
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
        $result = Database::select("sessions", array("*"), array("token='$token'"));
        if ($result->rowCount==1) {
            return Database::update("sessions", array("active"), array(0));
        }
    }

    public static function check($token)
    {
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
        // Updating token
        $token = TokenHelper::decode($token);
        $token->exp = self::getExpirationDate();
        $token = TokenHelper::encode($token);
        $result = Database::update("sessions", array("token"), array($token));
        $result->token = $token;

        return $result;
    }
}
