<?php
require_once '../secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['saveNotice'])) {
    $owner = new owner();
    $owner->text = Helper::clearString($_POST['text']);
    $owner->user_id = Helper::clearint($_POST['user_id']);
    $owner->child_id = Helper::clearint($_POST['child_id']);
    $owner->subject_id = Helper::clearint($_POST['subject_id']);
    $owner->subject_count = Helper::clearint($_POST['subject_count']);
    $owner->subject_price = Helper::clearint($_POST['subject_price']);
    $owner->link = Helper::clearString($_POST['link']);
    $owner->date = Helper::clearString($_POST['date']);
    if ((new ownerMap())->insertNotice($owner)) {
        header('Location: ../select-parent?message=ok');
    } else {
        header('Location: ../select-parent?message=err');
    }
}

if (isset($_POST['saveNoticeForParent'])) {
    $student = new Student();
    $studentMap = new StudentMap();
    $paymentArchives = $studentMap->selectgrades();
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

