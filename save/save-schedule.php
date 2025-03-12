<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['lesson_plan_id'])) {
    $schedule = new Schedule();
    $schedule->lesson_plan_id = Helper::clearInt($_POST['lesson_plan_id']);
    $schedule->date = $_POST['date'];
    $schedule->classroom_id = Helper::clearInt($_POST['classroom_id']);
    $userId = Helper::clearInt($_POST['user_id']);
    $scheduleMap = new ScheduleMap();
    if ($schedule->validate()) {
        if ($scheduleMap->save($schedule)) {
            header("Location: ../list/list-schedule?id=$userId&message=ok");
        } else {
            Helper::setFlash('Не удалось сохранить
расписание.');
            header("Location: ../add/add-schedule?idUser=$userId");
        }
    } else {
        Helper::setFlash('Такое расписание для
преподавателя или группы уже существует.');
        header("Location: ../add/add-schedule?idUser=$userId");
    }
} else {
    header('Location: 404');
}

