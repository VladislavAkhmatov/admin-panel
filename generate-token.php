<?php
require_once 'autoload.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['login'])) {
    http_response_code(400);
    echo json_encode(["error" => "Телефон не указан"]);
    exit;
}

$phone = Helper::clearString($data['login']);
$userMap = new UserMap();
$user = $userMap->getUserByUsername($phone);

if (!$user) {
    http_response_code(404);
    echo json_encode(["error" => "Пользователь не найден"]);
    exit;
}

$token = $userMap->generateToken($phone);
echo json_encode(["token" => $token]);
