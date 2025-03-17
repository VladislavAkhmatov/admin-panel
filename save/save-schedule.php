<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Доступ запрещен']);
    exit();
}

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawData = file_get_contents('php://input');
    $input = json_decode($rawData, true);

    if (!$input) {
        echo json_encode(['error' => 'Ошибка парсинга JSON']);
        exit();
    }

    // --- Запрос расписания по месяцу ---
    if (isset($input['group'], $input['subject'], $input['teacher'], $input['month'], $input['classroom']) &&
        !isset($input['day'], $input['time'])) {

        $schedule = new ScheduleMap();
        $events = $schedule->getEvents(
            $input['group'], $input['subject'], $input['teacher'],
            $input['month'], $input['classroom']
        );

        echo json_encode($events ?: []);
        exit();
    }

    // --- Запрос расписания для конкретного дня ---
    if (!empty($input['day']) && empty($input['group']) && empty($input['subject']) && empty($input['teacher'])) {
        $schedule = new ScheduleMap();
        $events = $schedule->getEventsByDay($input['day']); // Должен быть новый метод
        echo json_encode($events ?: []);
        exit();
    }

    // --- Сохранение нового занятия ---
    if (!empty($input['group']) && !empty($input['subject']) && !empty($input['teacher']) &&
        !empty($input['month']) && !empty($input['classroom']) && !empty($input['day']) && !empty($input['time'])) {

        $schedule = new ScheduleMap();
        if ($schedule->save(
            $input['group'], $input['subject'], $input['teacher'],
            $input['day'], $input['time'], $input['classroom']
        )) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Не удалось сохранить данные']);
        }
        exit();
    }

    echo json_encode(['error' => 'Некорректные входные данные']);
    exit();
}
?>
