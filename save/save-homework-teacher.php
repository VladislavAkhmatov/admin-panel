<?php
require_once '../secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['saveHomeworkTeacher'])) {
    $teacher = new Teacher();
    $teacher->name = $_POST['name'];
    $teacher->gruppa_id = $_POST['gruppa_id'];
    $teacher->date_begin = $_POST['date_begin'];
    $teacher->date_end = $_POST['date_end'];
    $teacher->subject_id = $_POST['subject_id'];
    $teacher->file = time() . "_" . $_FILES["file"]["name"];
    $fileTmpName = $_FILES["file"]["tmp_name"];

    move_uploaded_file($fileTmpName, "../homework-teacher/" . $teacher->file);

    if ((new TeacherMap())->createHomework($teacher)) {
        header('Location: ../check/check-homework?message=ok');
    } else {
        header('Location: ../check/check-homework?message=err');
    }
}

