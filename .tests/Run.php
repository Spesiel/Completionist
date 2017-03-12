<?php namespace Completionist\Tests;

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/TestFunctions.php";

printf("<h1>Tests</h1><hr/>");

/***********************************************/
printf("<h2>Helper</h2><hr/>");

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Helper/PasswordHelperTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Helper/TokenHelperTests.php";

/***********************************************/
printf("<h2>Dao</h2><hr/>");

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

printf("<hr/><hr/>eof");
