<?php namespace Completionist\Helper;

/**
 * JSON Web Token implementation, based on this spec:
 * https://tools.ietf.org/html/rfc7519
 *
 * This is completely perfectly fit to our needs, not the standard
 */

class TokenHelper
{
    const SECRET = "Completionist project --- 2017/02/20@1301UTC-6 --- nRT!s3G&IpuQaszRHTrh4d&4k#83&PyC";

    public static function encode($payload)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\Base64Helper.php";

        $header = array(
            "typ"=>"jwt",
            "alg"=>"HS256"
        );

        $header = Base64Helper::encode(json_encode($header));
        $payload = Base64Helper::encode(json_encode($payload));
        $signature = Base64Helper::encode(static::getSignature($header, $payload));

        return implode(".", array($header,$payload,$signature));
    }

    public static function decode($token)
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\Base64Helper.php";
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";

        list($header, $payload, $signature) = explode(".", $token);

        if (!self::check(array($header, $payload, $signature))) {
            throw new CompletionistException("=== Invalid signature on token");
        }

        return json_decode(Base64Helper::decode($payload));
    }

    public static function check($token = array())
    {
        require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helper\Base64Helper.php";

        return hash_equals(
            $token[2],
            Base64Helper::encode(static::getSignature($token[0], $token[1]))
        );
    }

    private static function getSignature($header, $payload)
    {
        return hash_hmac("sha256", implode(".", array($header, $payload)), self::SECRET, true);
    }
}
