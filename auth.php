<?php
require_once 'autoload.php';
session_start();

$message = 'Войдите для просмотра расписания занятий';

// Если передан username из Telegram, пытаемся войти
if (isset($_GET['phone'])) {
    $phone = Helper::clearString($_GET['phone']);
    $userMap = new UserMap();
    $user = $userMap->getUserByUsername($phone); // Проверяем пользователя
    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;

        header('Location: index.php'); // Перенаправляем в кабинет
        exit;
    } else {
        $message = '<span style="color:red;">Пользователь не найден</span>';
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
