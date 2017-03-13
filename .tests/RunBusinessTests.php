<?php namespace Completionist\Tests;

/***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business.php";
printf("<h2>Business</h2>");

require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/UsersTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/SessionsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/FriendsTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/MessagesTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
//
printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/RolesTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
//
printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/GamesTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
//
printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/BookmarksTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
//
printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Business/CompletionTests.php";
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";
/***********************************************/

printf("<hr/>RunBusinessTests - eof<hr/><hr/>");
