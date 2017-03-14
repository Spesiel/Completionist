<?php namespace Completionist;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\CompletionistException.php";

// Link to database functions and tables
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Result.php";

// Specific business layer files
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Bookmarks.php";
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Completion.php";
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Friends.php";
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Games.php";
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Messages.php";
// require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Sessions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
