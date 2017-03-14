<?php namespace Completionist\Tests\Units;

// Reset the database to default values (Truncate and AutoInc=1)
require $_SERVER["DOCUMENT_ROOT"]."/.tests/Units/reset.php";

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Dao\Users.php";
require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Business\Users.php";
use Completionist\Business\Users as Users;

Users::create("admin", "", "admin");
Users::setRole(1, 127);

Users::create("poweruser", "", "poweruser");
Users::setRole(3, 63);

Users::create("user", "", "user");
