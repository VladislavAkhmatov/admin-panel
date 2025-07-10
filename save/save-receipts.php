<?php
require_once "../secure.php";
if (!Helper::can('admin')) {
    header("Location: 404");
    exit;
}

if (isset ($_POST["sendReceipt"])) {
    $type = $_POST["type"];
    $note = $_POST["note"];
    $full_path = '../receipts/' . time() . '_' . $_FILES["file"]["name"];
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $full_path)) {
        if ((new ReceiptMap())->insert($type, $note, $full_path)) {
            Header('Location: /send-receipt?q=ok');
            exit();
        } else {
            Header('Location: /send-receipt?q=err');
            exit();
        }
    }
}