<?php namespace Completionist\Helper;

class Base64Helper
{
    public static function encode($message)
    {
        $message = base64_encode($message);
        $message = strtr($message, "+/", "-_");
        return str_replace("=", "", $message);
    }

    public static function decode($message)
    {
        $modulo = strlen($message)%4;
        if ($modulo) {
            $padding = 4 - $modulo;
            $message .= str_repeat("=", $padding);
        }
        $message = strtr($message, "-_", "+/");
        return base64_decode($message);
    }
}
