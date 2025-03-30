<?php
require_once '../secure.php';
if(!Helper::can('owner') && !Helper::can('admin')){
    header('Location: 404');
    exit();
}

if(isset($_POST['parent_id'])){
    $parent_id = $_POST['parent_id'];
    $child_id = $_POST['child_id'];

    if((new ProcreatorMap())->deleteChildById($parent_id, $child_id)){
        header('location: ../list/list-parent?q=ok');
        exit();
    }else{
        header('location: ../list/list-parent?q=err');
        exit();
    }
}