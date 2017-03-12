<?php namespace Completionist\Tests;

/***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";
printf("<h2>Dao</h2>");

require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/UsersTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/SessionsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/GamesTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/CompletionTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/BookmarksTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/FriendsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Dao/RolesTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
/***********************************************/

printf("<hr/>RunDaoTests - eof<hr/><hr/>");
