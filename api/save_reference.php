<?php
require_once "../autoload.php";
header("Content-Type: application/json; charset=UTF-8");

$uploadPath = '../uploads/';

if (!isset($_FILES['reference']) || !isset($_POST['user_id'])) {
    echo json_encode(["error" => "Missing file or user_id"]);
    exit;
}

$user_id = $_POST['user_id'];

$fileName = time() . '_' . basename($_FILES['reference']['name']);
$target_file = $uploadPath . $fileName;

// Перемещение загруженного файла
if (move_uploaded_file($_FILES['reference']['tmp_name'], $target_file)) {
    (new Api())->addReference($user_id, $target_file);
} else {
    echo json_encode(["error" => "There was an error uploading your file."]);
}
