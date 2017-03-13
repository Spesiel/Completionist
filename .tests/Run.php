<?php namespace Completionist\Tests;

require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/TestFunctions.php";

printf("<h1>Tests</h1><hr/><hr/>");

/***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/RunHelperTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/RunDaoTests.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/RunBusinessTests.php";
/***********************************************/

printf("eof");
