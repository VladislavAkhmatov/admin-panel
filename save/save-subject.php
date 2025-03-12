<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['name'])) {
    $subject = new Subject();
    $subject->subject_id = Helper::clearInt($_POST['subject_id']);
    $subject->name = Helper::clearString($_POST['name']);
    $subject->otdel_id = Helper::clearInt($_POST['otdel_id']);
    if ((new SubjectMap())->save($subject)) {
        header('Location: ../view/view-subject?id=' . $subject->subject_id);
    } else {
        if ($subject->subject_id) {
            header('Location: ../add/add-subject?id=' . $subject->subject_id);
        } else {
            header('Location: ../add/add-subject');
        }
    }
}
