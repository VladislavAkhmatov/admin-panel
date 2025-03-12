<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['otdel_id'])) {
    $otdel = new Otdel();
    $otdel->otdel_id = Helper::clearInt($_POST['otdel_id']);
    $otdel->name = Helper::clearString($_POST['name']);
    if ((new OtdelMap())->save($otdel)) {
        header('Location: ../view/view-otdel?id=' . $otdel->otdel_id);
    } else {
        if ($otdel->otdel_id) {
            header('Location: ../add/add-otdel?id=' . $otdel->otdel_id);
        } else {
            header('Location: ../add/add-otdel');
        }
    }
}
