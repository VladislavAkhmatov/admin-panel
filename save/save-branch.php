<?php

require_once "../secure.php";

if (!Helper::can('owner')) {
    header("Location: 404");
    exit;
}

if (isset ($_POST["saveBranch"])) {
    $branch = $_POST['branch'];
    $id = $_POST['id'];
    if ($id == 0) {
        if ((new BranchMap())->insert($branch)) {
            header("Location: ../list/list-branch?message=ok");
            exit();
        } else {
            header("Location: ../list/list-branch?message=err");
            exit();
        }
    }
    else{
        if ((new BranchMap())->update($id, $branch)) {
            header("Location: ../list/list-branch?message=ok");
            exit();
        } else {
            header("Location: ../list/list-branch?message=err");
            exit();
        }
    }
}