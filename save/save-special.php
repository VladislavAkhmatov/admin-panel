<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset ($_POST['special_id'])) {
    $special = new Special();
    $special->special_id = Helper::clearInt($_POST['special_id']);
    $special->subject_id = Helper::clearInt($_POST['subject_id']);
    $special->time_begin = Helper::clearString($_POST['time_begin']);
    $special->time_end = Helper::clearString($_POST['time_end']);

    if ((new SpecialMap())->save($special)) {
        header('Location: ../view/view-time?id=' . $special->special_id);
    } else {
        if ($special->special_id) {

            header('Location: ../add/add-time?id=' . $special->special_id);

        } else {
            header('Location: ../add/add-time');
        }
    }
}

