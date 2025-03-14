<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['group'], $input['subject'], $input['teacher'], $input['month'])) {
        // Здесь можно добавить логику для получения данных календаря из базы данных
        // и возвращения их в формате JSON

        // Пример данных календаря
        $events = [
            [
                'title' => 'Событие 1',
                'start' => '2023-10-01T10:00:00',
                'end' => '2023-10-01T12:00:00'
            ],
            [
                'title' => 'Событие 2',
                'start' => '2023-10-15T14:00:00',
                'end' => '2023-10-15T16:00:00'
            ]
        ];
        echo json_encode($events);
    } elseif (isset($input['group'], $input['subject'], $input['teacher'], $input['month'], $input['day'], $input['time'])) {
        // Здесь можно добавить логику для сохранения данных в базу данных

        $success = true; // Пример успешного сохранения
        echo json_encode(['success' => $success]);
    }
}
?>