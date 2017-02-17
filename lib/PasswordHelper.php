<?php namespace Completionistv2;

class PasswordHelper
{
    const SECRET = "Completionist project --- 2017/02/16@2100UTC-6";

    public static function encode($password)
    {
        return base64_encode(hash_hmac("sha256", $password, self::SECRET, false));
    }

    public static function check($password, $hash)
    {
        return hash_equals(base64_decode($hash), base64_decode(static::encode($password)));
    }
}
