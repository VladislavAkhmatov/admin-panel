<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['user_id'])) {
    $student = new Student();
    $student->user_id = $_POST['user_id'];
    $student->reference = time() . '_' . $_FILES["reference"]["name"];
    $fileTmpName = $_FILES["reference"]["tmp_name"];

    move_uploaded_file($fileTmpName, "../references/" . $student->reference);

    if ((new StudentMap())->insertReference($student)) {
        header('Location: ../index?message=err');
        exit();
    } else {
        header('Location: ../profile/profile-student?id=' . $student->user_id);
        exit();
    }
}