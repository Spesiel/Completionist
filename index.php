<?php
namespace Completionistv2;

require_once $_SERVER["DOCUMENT_ROOT"]."\lib\Database.php";

$result = Database::select("users");
echo "Count: ".$result->rowCount;
var_dump($result->rows);
