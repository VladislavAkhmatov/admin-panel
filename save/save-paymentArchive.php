<?php
require_once '../secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['paymentSubmit'])) {
    $student = new Student();
    $studentMap = new StudentMap();
    $paymentArchives = $studentMap->selectgrades();
    $student->parent_id = Helper::clearInt($_POST['parent_id']);
    $student->user_id = Helper::clearInt($_POST['child_id']);
    $student->subject_id = Helper::clearInt($_POST['subject_id']);
    $student->id = Helper::clearInt($_POST['id']);
    $student->count = $_POST['count'];
    $student->tab = $_POST['tab'];
    $student->price = $_POST['price'];
    $student->attend = 1;

    foreach ($paymentArchives as $paymentArchive) {
        if ($paymentArchive->child_id == $student->user_id && $paymentArchive->subject_id == $student->subject_id) {
            (new StudentMap())->saveUpdatePaymentArchive($student);
            header('Location: ../check/check-payment?message=ok');
            exit();
        }
    }

    if ((new StudentMap())->savePaymentArchive($student)) {
        header('Location: ../check/check-payment?message=ok');
        exit();
    } else {
        header('Location: ../check/check-payment?message=err');
        exit();
    }

}




if (isset($_POST['paymentDelete'])) {
    $student = new Student();
    $student->id = Helper::clearInt($_POST['id']);
    $student->text = Helper::clearString($_POST['text']);
    $student->subject_id = Helper::clearInt($_POST['subject_id']);
    $student->parent_id = Helper::clearInt($_POST['parent_id']);
    $student->child_id = Helper::clearInt($_POST['child_id']);
    $student->subject_count = Helper::clearInt($_POST['subject_count']);
    $student->subject_price = Helper::clearInt($_POST['subject_price']);
    if ((new StudentMap())->deletePayment($student)) {
        header('Location: ../check/check-payment?message=okDel');
        exit();
    } else {
        header('Location: ../check/check-payment?message=errDel');
        exit();
    }
}
