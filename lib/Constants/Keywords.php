<?php namespace Completionist\Constants;

class Keywords implements IConstants
{
    const DBTIMESTAMP = "CURRENT_TIMESTAMP";

    private static $list = array(
        self::DBTIMESTAMP => self::DBTIMESTAMP
    );

    public static function exists($constant)
    {
        return array_key_exists($constant, self::$list);
    }
}
