<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = Helper::clearInt($_GET['id']);
$idPlan = Helper::clearInt($_GET['idplan']);
if ((new ScheduleMap())->existsScheduleByLessonPlanId($id) || !(new LessonPlanMap())->delete($id)) {
    Helper::setFlash('Не удалось удалить пункт плана. К нему привязанно расписание.');
}
header('Location: ../list/list-plan?id=' . $idPlan);
