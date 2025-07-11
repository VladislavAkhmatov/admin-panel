<?php

require_once "../autoload.php";

header("Content-Type: application/json; charset=UTF-8");

$id = 0;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

(new Api())->getReferences($id);
