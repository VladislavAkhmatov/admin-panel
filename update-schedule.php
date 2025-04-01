<?php
header('Content-Type: application/json');
require_once 'secure.php'; // Подключаем файл с настройками БД

$response = ['success' => false, 'message' => ''];

try {
    // Получаем данные из тела запроса
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Неверные данные запроса');
    }

    // Проверяем обязательные поля
    $requiredFields = ['schedule_id', 'time', 'subject', 'teacher', 'classroom', 'group'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) {
            throw new Exception("Отсутствует обязательное поле: $field");
        }
    }

    if ((new ScheduleMap())->update($input['schedule_id'], $input['time'], $input['subject'], $input['teacher'], $input['classroom'], $input['group'])) {
        $response = ['success' => true];
        $response = ['message' => 'Изменения успешно сохраненны'];
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>