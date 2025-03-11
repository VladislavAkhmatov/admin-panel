<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['saveHomeworkStudent'])) {
    $procreator = new Procreator();
    $procreator->homework_teacher_id = $_POST['homework_teacher_id'];
    $procreator->name = $_POST['name'];
    $procreator->teacher_id = $_POST['teacher_id'];
    $procreator->gruppa_id = $_POST['gruppa_id'];
    $procreator->child_id = $_POST['student_id'];
    $procreator->date_begin = $_POST['date_begin'];
    $procreator->date_end = $_POST['date_end'];
    $procreator->subject_id = $_POST['subject_id'];
    $procreator->file = $_POST['file'];

    $procreator->file_prepared = time() . "_" . $_FILES["file_prepared"]["name"];
    $fileTmpName = $_FILES["file_prepared"]["tmp_name"];

    move_uploaded_file($fileTmpName, "../homework-student/" . $procreator->file_prepared);

    if ((new ProcreatorMap())->insertHomeworkFromParent($procreator)) {
        header('Location: ../list/list-homework?message=ok');
    } else {
        header('Location: ../list/list-homework?message=err');
    }
}