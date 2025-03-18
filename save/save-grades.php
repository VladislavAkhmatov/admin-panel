<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['user_ids'])) {
    $grade = new GradeMap();

    $user_ids = $_POST['user_ids'];
    $schedule_id = $_POST['schedule_id'];
    $attends = $_POST['attends'];
    $activities = $_POST['activities'];
    $homeworks = $_POST['homeworks'];

    for ($i = 0; $i < count($user_ids); $i++) {
        $user_id = $user_ids[$i];
        $activity = $activities[$i];
        $attend = $attends[$i] ?? 0;
        $homework = $homeworks[$i];
        try {
            $grade->save($user_id, $schedule_id, $activity, $attend, $homework);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
