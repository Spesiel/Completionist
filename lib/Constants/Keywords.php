<?php namespace Completionist\Constants;

class Keywords implements IConstants
{
    const DBTIMESTAMP   = "CURRENT_TIMESTAMP";
    const DBSELECT      = "SELECT";
    const DBINSERT      = "INSERT";
    const DBUPDATE      = "UPDATE";
    const DBDELETE      = "DELETE";

    private static $list = array(
        self::DBTIMESTAMP => self::DBTIMESTAMP
    );

    public static function exists($constant)
    {
        return array_key_exists($constant, self::$list);
    }
}
