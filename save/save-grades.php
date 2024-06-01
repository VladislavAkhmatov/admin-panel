<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['gradeSubmit'])) {
    $student = new Student();
    $studentMap = new StudentMap();
    $paymentArchives = $studentMap->selectGrades();
    $student->grade_id = Helper::clearInt($_POST['grade_id']);
    $student->user_id = Helper::clearInt($_POST['user_id']);
    $student->subject_id = Helper::clearInt($_POST['subject_id']);
    $student->grade = Helper::clearInt($_POST['grade']);
    $student->date = Helper::clearString($_POST['date']);
    $student->attend = Helper::clearInt($_POST['attend']);
    $student->comment = Helper::clearString($_POST['comment']);
    $student->file = Helper::clearString($_POST['homework']);

    foreach ($paymentArchives as $paymentArchive) {
        if ((new StudentMap())->saveUpdateGrades($student)) {
            header('Location: ../check/check-grades?message=ok');
            exit();
        } else {
            header('Location: ../check/check-grades?message=errGrades');
            exit();
        }
    }
}


if (isset($_POST['gradeDelete'])) {
    $student = new Student();
    $student->grade_id = Helper::clearInt($_POST['grade_id']);
    if ((new StudentMap())->deleteGrades($student)) {
        header('Location: ../check/check-grades?message=errDel');
    } else {
        if ($student->user_id) {
            header('Location: ../check/check-grades?message=okDel');
        } else {
            header('Location: ../check/check-grades?message=okDel');
        }
    }
}
