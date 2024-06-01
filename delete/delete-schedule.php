<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$id = Helper::clearInt($_GET['id']);
$idTeacher = Helper::clearInt($_GET['idTeacher']);
(new ScheduleMap())->delete($id);
header('Location: ../list/list-schedule?id=' . $idTeacher);

