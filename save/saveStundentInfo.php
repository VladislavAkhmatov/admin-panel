<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}

echo $_POST['user_id'];