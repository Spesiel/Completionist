<?php namespace Completionist\Tests;

/***********************************************/
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Helpers.php";
printf("<h2>Helper</h2>");

printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Helper/PasswordHelperTests.php";
printf("<hr/>");
require_once $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/Helper/TokenHelperTests.php";
/***********************************************/

printf("<hr/>RunHelperTests - eof<hr/><hr/>");
