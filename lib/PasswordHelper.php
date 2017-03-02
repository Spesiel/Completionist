<?php namespace Completionist;

class PasswordHelper
{
    const SECRET = "Completionist project --- 2017/02/16@2127UTC-6 --- dqgb5&HP4J@Dn5gQwZ5oD8!KW!u2xXqu";

    public static function encode($password)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/lib/Base64Helper.php";

        return Base64Helper::encode(hash_hmac("sha256", $password, self::SECRET, false));
    }

    public static function check($password, $hash)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."/lib/Base64Helper.php";

        return hash_equals(Base64Helper::decode($hash), Base64Helper::decode(static::encode($password)));
    }
}
