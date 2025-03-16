<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawData = file_get_contents('php://input');
    $input = json_decode($rawData, true);

    if (isset($input['group'], $input['subject'], $input['teacher'], $input['month'], $input['classroom']) && !isset($input['day'], $input['time'])) {
        // --- Получение событий для календаря ---
        $group_id = $input['group'];
        $subject_id = $input['subject'];
        $teacher_id = $input['teacher'];
        $month = $input['month'];
        $classroom = $input['classroom'];

        $schedule = new ScheduleMap();
        $events = $schedule->getEvents($group_id, $subject_id, $teacher_id, $month, $classroom);

        echo json_encode($events);

    } elseif (!empty($input['group']) && !empty($input['subject']) && !empty($input['teacher']) && !empty($input['month'] && !empty($input['classroom'])) && !empty($input['day']) && !empty($input['time'])) {
        $group_id = $input['group'];
        $subject_id = $input['subject'];
        $teacher_id = $input['teacher'];
        $day = $input['day'];
        $time = $input['time'];
        $classroom = $input['classroom'];

        $schedule = new ScheduleMap();
        if ($schedule->save($group_id, $subject_id, $teacher_id, $day, $time, $classroom)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Не удалось сохранить данные']);
        }
    }
}

?>