<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
if (isset($_POST['saveChildParent'])) {
    $parent = new Procreator();
    $parent->user_id = Helper::clearInt($_POST['user_id']);
    $parent->child_id = Helper::clearInt($_POST['child_id']);
    $parentMap = new ProcreatorMap();
    if ($parentMap->saveChild($parent)) {

        header('Location: ../list/list-parent');
    } else {
        header('Location: ../add/add-child-parent');
    }
}
