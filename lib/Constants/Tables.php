<?php namespace Completionist\Constants;

class Tables implements IConstants
{
    const USERS         = "users";
    const GAMES         = "games";
    const SESSIONS      = "sessions";
    const BOOKMARKS     = "bookmarks";
    const FRIENDS       = "friends";
    const MESSAGES      = "messages";
    const COMPLETION    = "completion";

    const LISTING = array(
        self::USERS         => array("name","email","hash"),
        self::GAMES         => array("name","link","comment","userid"),
        self::SESSIONS      => array("token","userid"),
        self::BOOKMARKS     => array("userid","gameid"),
        self::FRIENDS       => array("friendid","userid"),
        self::MESSAGES      => array("fromuserid","touserid","title","body"),
        self::COMPLETION    => array("userid","gameid","status","comment")
    );

    public static function exists($constant)
    {
        return array_key_exists($constant, self::LISTING);
    }
}
