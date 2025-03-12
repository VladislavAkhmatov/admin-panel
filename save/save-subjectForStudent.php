<?php
require_once "../secure.php";
if (!Helper::can('admin') && !Helper::can('owner')) {
    header('Location: 404');
    exit;
}

if (isset ($_POST['saveSubjectForStudent'])) {
    $student = new Student();
    $student->user_id = $_POST['user_id'];
    $student->subject_id = $_POST['subject_id'];
    if ((new StudentMap())->saveSubjectForStudent($student)) {
        header('Location: ../list/list-student?message=ok');
        exit;
    } else {
        header('Location: ../list/list-student?message=errs');
        exit;
    }
}
?>