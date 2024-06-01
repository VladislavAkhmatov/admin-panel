<?php
require_once 'autoload.php';
session_start();

(new UserMap())->autoNotifications();

$message = 'Войдите для просмотра расписания занятий';
if (
    isset($_POST['login']) &&
    isset($_POST['password'])
) {
    $login = Helper::clearString($_POST['login']);
    $password = Helper::clearString($_POST['password']);
    $userMap = new UserMap();
    $user = $userMap->auth($login, $password);
    if ($user) {
        $_SESSION['id'] = $user->user_id;
        $_SESSION['role'] = $user->sys_name;
        $_SESSION['roleName'] = $user->name;
        $_SESSION['fio'] = $user->fio;
        $_SESSION['branch'] = $user->branch;
        $_SESSION['branch_name'] = $user->branch_name;
        $_SESSION['photo'] = $user->photo;
        header('Location: template/branch');
        exit;
    } else {
        $message = '<span style="color:red;">Некорректен
логин или пароль</span>';
    }
}

if (isset($_POST['branch'])) {

    $res = explode(',', $_POST['branch']);
    $branch_id = $res[0];
    $branch_name = $res[1];

    if (Helper::can('admin')) {
        $_SESSION['branch'] = $branch_id;
        $_SESSION['branch_name'] = $branch_name;
        header("Location: index");
        exit;
    }

    if ($_SESSION['branch'] != $branch_id) {
        header("Location: template/branch?message=errBranch");
        exit;
    }
    header("Location: index");

}

require_once ('template/login.php');
?>