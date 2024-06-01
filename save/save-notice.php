<?php
require_once '../secure.php';
if (!Helper::can('manager')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['saveNotice'])) {
    $admin = new Admin();
    $admin->text = Helper::clearString($_POST['text']);
    $admin->user_id = Helper::clearint($_POST['user_id']);
    $admin->child_id = Helper::clearint($_POST['child_id']);
    $admin->subject_id = Helper::clearint($_POST['subject_id']);
    $admin->subject_count = Helper::clearint($_POST['subject_count']);
    $admin->subject_price = Helper::clearint($_POST['subject_price']);
    $admin->link = Helper::clearString($_POST['link']);
    $admin->date = Helper::clearString($_POST['date']);
    if ((new AdminMap())->insertNotice($admin)) {
        header('Location: ../select-parent?message=ok');
    } else {
        header('Location: ../select-parent?message=err');
    }
}

if (isset($_POST['saveNoticeForParent'])) {
    $student = new Student();
    $studentMap = new StudentMap();
    $paymentArchives = $studentMap->selectGrades();
    $student->parent_id = Helper::clearInt($_POST['user_id']);
    $student->user_id = Helper::clearInt($_POST['child_id']);
    $student->subject_id = Helper::clearInt($_POST['subject_id']);
    $student->id = Helper::clearInt($_POST['id']);
    $student->count = $_POST['subject_count'];
    $student->tab = $_POST['tab'];
    $student->price = $_POST['subject_price'];
    $student->payment_method = $_POST['payment_method'];
    $student->attend = 1;

    foreach ($paymentArchives as $paymentArchive) {
        if ($paymentArchive->child_id == $student->user_id && $paymentArchive->subject_id == $student->subject_id) {
            (new StudentMap())->saveUpdatePaymentArchive($student);
            header('Location: ../select-parent?message=ok');
            exit();
        }
    }

    if ((new StudentMap())->savePaymentArchive($student)) {
        header('Location: ../select-parent?message=ok');
        exit();
    } else {
        header('Location: ../select-parent?message=err');
        exit();
    }
}

