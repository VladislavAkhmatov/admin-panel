<?php

require_once "../autoload.php";

header("Content-Type: application/json; charset=UTF-8");

$login = "";

if (isset($_GET["login"])) {
    $login = $_GET["login"];
}

(new Api())->getUser($login);
