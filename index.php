<?php
namespace Completionistv2;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Users.php";

$result = Users::select();
echo "Count: ".$result->rowCount;
var_dump($result->rows);
