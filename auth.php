<?php
require_once 'autoload.php';
session_start();

$message = 'Войдите для просмотра расписания занятий';

if ($_GET['login']) {
    $login = $_GET['login'];
    $userMap = new UserMap();
    $password = 0;
    $additional_login = "";
    $user = $userMap->authFromTelegram($login);
    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['roleName'] = $user->role;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;
        if ($_SESSION['role'] == "student") {
            $_SESSION['points'] = $user->points;
        }
        header('Location: index.php');
        exit;
    } else {
        echo '<span style="color:red;">Неверный или устаревший токен</span>';
    }
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = Helper::clearString($_POST['login']);
    $password = Helper::clearString($_POST['password']);
    $additional_login = Helper::clearString($_POST['login']);
    $userMap = new UserMap();
    $user = $userMap->auth($login, $password, $additional_login);

    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['roleName'] = $user->role;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;
        if ($_SESSION['role'] == "student") {
            $_SESSION['points'] = $user->points;
        }
        header('Location: index.php');
        exit;
    } else {
        $message = '<span style="color:red;">Некорректен логин или пароль</span>';
    }
}

require_once('template/login.php');
?>
