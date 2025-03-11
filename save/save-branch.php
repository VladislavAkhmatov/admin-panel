<?php

require_once "../secure.php";

if (!Helper::can('admin')) {
    header("Location: 404");
    exit;
}

if (isset ($_POST["saveBranch"])) {
    $admin = new Admin();
    $admin->text = $_POST['branch'];
    if ((new AdminMap())->saveBranch($admin)) {
        header("Location: ../list/list-branch?message=ok");
        exit();
    } else {
        header("Location: ../list/list-branch?message=err");
        exit();
    }

}