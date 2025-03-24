<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['user_ids'])) {
    $grade = new GradeMap();
    $balance = new BalanceMap();
    $user_ids = $_POST['user_ids'];
    $attends = $_POST['attends'];
    $activities = $_POST['activities'];
    $homeworks = $_POST['homeworks'];
    $schedule_id = $_POST['schedule_id'];
    $subject_id = $_POST['subject_id'];

    try {
        $grade->db->beginTransaction();

        for ($i = 0; $i < count($user_ids); $i++) {
            $user_id = $user_ids[$i];
            $activity = $activities[$i] == '' ? null : $activities[$i];
            $attend = $attends[$user_id] ?? 0;
            $homework = $homeworks[$i] == '' ? null : $homeworks[$i];
            if ($grade->findGradeByUserAndSchedule($user_id, $schedule_id)) {
                $grade->update($user_id, $schedule_id, $activity, $attend, $homework);
            } else {
                $grade->insert($user_id, $schedule_id, $activity, $attend, $homework);
                $balance->withdraw($user_id, $subject_id);
            }
        }

        $grade->db->commit();
    } catch (Exception $e) {
        $grade->db->rollback();
        var_dump($e->getMessage());
        header('Location: ../select-schedule?q=err');
        exit();
    }
    header('Location: ../select-schedule?q=ok');
    exit();
}
