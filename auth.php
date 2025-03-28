<?php
require_once 'autoload.php';
session_start();

$message = 'Войдите для просмотра расписания занятий';

// Если передан username из Telegram, пытаемся войти
if (isset($_GET['token'])) {
    $token = Helper::clearString($_GET['token']);
    $userMap = new UserMap();
    $user = $userMap->getUserByToken($token);
    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;

        // Удаляем использованный токен
        $userMap->deleteToken($token);

        header('Location: index.php');
        exit;
    } else {
        echo '<span style="color:red;">Неверный или устаревший токен</span>';
    }
}

// Обычная авторизация через логин/пароль
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = Helper::clearString($_POST['login']);
    $password = Helper::clearString($_POST['password']);
    $userMap = new UserMap();
    $user = $userMap->auth($login, $password);

    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;

        header('Location: index.php');
        exit;
    } else {
        $message = '<span style="color:red;">Некорректен логин или пароль</span>';
    }
}

require_once ('template/login.php');
?>
