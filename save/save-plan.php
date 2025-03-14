<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset ($_POST['gruppa_id'])) {
    $plan = new LessonPlan();
    $plan->user_id = Helper::clearInt($_POST['user_id']);
    $plan->gruppa_id = Helper::clearInt($_POST['gruppa_id']);
    $plan->subject_id = Helper::clearInt($_POST['subject_id']);
    $planMap = new LessonPlanMap();
    if ($plan->validate() && !$planMap->existsPlan($plan)) {
        if ($planMap->save($plan)) {

            header('Location: ../list/list-plan?id=' . $plan->user_id);
        } else {
            Helper::setFlash('Не удалось сохранить план.');
            header('Location: ../add/add-plan?id=' . $plan->user_id);
        }
    } else {
        Helper::setFlash('Такой план уже существует.');
        header('Location: ../add/add-plan?id=' . $plan->user_id);
    }
} else {
    header('Location: 404');
}