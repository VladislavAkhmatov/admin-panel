<?php

require_once "../secure.php";

if (!Helper::can('owner')) {
    header("Location: 404");
    exit;
}

if (isset ($_POST["saveBranch"])) {
    $owner = new owner();
    $owner->text = $_POST['branch'];
    if ((new ownerMap())->saveBranch($owner)) {
        header("Location: ../list/list-branch?message=ok");
        exit();
    } else {
        header("Location: ../list/list-branch?message=err");
        exit();
    }

}