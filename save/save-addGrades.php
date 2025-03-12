<?php
require_once '../secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['formSubmit'])) {
    $flag = false;
    foreach ($_POST['grades_id'] as $user_id => $grades) {
        $student = new Student();
        $schedule_id = $_POST['schedule_id'];
        $lesson_plan_id = $_POST['lesson_plan_id'];
        $student->subject_id = $_POST['subject_id'][$user_id];
        $student->user_id = $user_id;
        $student->attend = $_POST['attend'][$user_id];
        $student->grade = $grades;
        $student->comment = $_POST['comment'][$user_id];
        (new StudentMap())->saveAddgrades($student);
        $flag = true;
    }
    if ($flag) {
        if ((new ScheduleMap())->updatePlan($schedule_id, $lesson_plan_id)) {
            header('Location: ../check/check-classes?message=ok');
            exit();
        } else {
            header('Location: ../check/check-classes?message=err');
            exit();
        }
    } else {
        header('Location: ../check/check-classes?message=err');
        exit();
    }

}

?>