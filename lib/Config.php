<?php namespace Completionist;

use \PDO;

class Config
{
    const DBCONNECTION = "mysql:host=".self::DBHOST.";dbname=".self::DBNAME.";charset=utf8mb4";
    const DBHOST = "localhost";
    const DBNAME = "completionist";
    const DBUSERNAME = "completionist";
    const DBPASSWORD = "default";
    const PDOOPTIONS = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
