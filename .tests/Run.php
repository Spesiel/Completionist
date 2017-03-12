<?php namespace Completionist\Tests;

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/TestFunctions.php";

printf("<h1>Tests</h1><hr/>");

/***********************************************/
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/PasswordHelperTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/TokenHelperTests.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/UsersTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/SessionsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/GamesTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/CompletionTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/BookmarksTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/FriendsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/RolesTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
/***********************************************/

printf("<hr/><hr/>eof");
