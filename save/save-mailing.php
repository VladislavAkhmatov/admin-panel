<?php
require_once "../secure.php";
if (!Helper::can('admin') && !Helper::can('owner')) {
    header("Location: 404");
    exit;
}

if (isset ($_POST["mailing"])) {
    $text = $_POST["message"];
    $end_period = $_POST["end_period"];
    if ((new MailingMap())->insert($text, $end_period)) {
        header("Location: ../mailing?q=ok");
        exit();
    } else {
        header("Location: ../mailing?q=err");
        exit();
    }
}