<?php namespace Completionist;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Constants.php";

// Base Database connection file
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Database.php";

// Specific database tables files
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Bookmarks.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Completion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Friends.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Games.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Messages.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Sessions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
