<?php
namespace Completionistv2;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";

/***********************************************
* Tests on select/insert/update
************************************************
$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);

$result = Users::insert("test", "", "testhash");
echo "Count: ".$result->rowCount;

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);

$result = Users::deactivate("test");
echo "Count: ".$result->rowCount;

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);
***********************************************/
