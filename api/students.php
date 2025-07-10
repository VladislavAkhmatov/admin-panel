<?php
require_once "../autoload.php";


$login = "";
if (isset($_GET['login'])) {
    $login = $_GET['login'];
} else {
    $login = $_SESSION['login'];
}

header("Content-Type: application/json; charset=UTF-8");

(new ProcreatorMap())->getStudentFromParentId($login);
