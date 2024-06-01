<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['gruppa_id'])) {
    $gruppa = new Gruppa();
    $gruppa->gruppa_id = Helper::clearInt($_POST['gruppa_id']);
    $gruppa->name = Helper::clearString($_POST['name']);
    $gruppa->date_begin = Helper::clearString($_POST['date_begin']);
    $gruppa->date_end = Helper::clearString($_POST['date_end']);
    if ((new GruppaMap())->save($gruppa)) {
        header('Location: ../view/view-gruppa?id=' . $gruppa->gruppa_id);
    } else {
        if ($gruppa->gruppa_id) {
            header('Location: ../add/add-gruppa?id=' . $gruppa->gruppa_id);
        } else {
            header('Location: ../add/add-gruppa');
        }
    }
}

