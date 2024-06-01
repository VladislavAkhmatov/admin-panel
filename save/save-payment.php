<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['savePayment'])) {
    $student = new Student();
    $id = $_POST['id'];
    $student->parent_id = Helper::clearInt($_SESSION['id']);
    $student->user_id = Helper::clearInt($_POST['child_id']);
    $student->subject_id = Helper::clearInt($_POST['subject_id']);
    $student->subject_count = Helper::clearInt($_POST['subject_count']);
    $student->subject_price = Helper::clearInt($_POST['subject_price']);
    $student->link = Helper::clearString($_POST['link']);
    $student->tab = time() . $_FILES["tab"]["name"];
    $fileTmpName = $_FILES["tab"]["tmp_name"];

    move_uploaded_file($fileTmpName, "../uploads/" . $student->tab);


    if ((new StudentMap())->savePayment($student)) {
        if ((new StudentMap())->deleteNoticeById($id)) {
            header('Location: ../view/view-notice?message=ok');
            exit();
        } else {
            header('Location: ../view/view-notice?message=err');
            exit();
        }
    } else {
        header('Location: ../view/view-notice?message=err');
        exit();
    }
}

