<?php namespace Completionist\Constants;

class Roles implements IConstants
{
    const ADMIN     = 127;
    const POWERUSER = 63;
    const USER      = 1;

    const LISTING = array(
        "admin"     => 127,
        "poweruser" =>  63,
        "user"      =>   1
    );
    const ROLES = array(
        127 => "admin",
         63 => "poweruser",
          1 => "user"
    );

    private static $list = array(
        self::ADMIN     => self::ADMIN,
        self::POWERUSER => self::POWERUSER,
        self::USER      => self::USER
    );

    public static function exists($constant)
    {
        return array_key_exists($constant, self::$list);
    }
}
