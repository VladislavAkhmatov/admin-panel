<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$idUser = Helper::clearInt($_GET['idUser']);
$idDay = Helper::clearInt($_GET['idDay']);
if ((new TeacherMap())->findById($idUser)->validate()) {
    $teacher = (new UserMap())->findProfileById($idUser);
} else {
    header('Location: 404');
}
$schedule = new ScheduleMap();
$header = 'Добавить расписание. Преподаватель: ' . $teacher->fio;
require_once '../template/header.php';
?>
<section class="content-header">
    <ol class="breadcrumb">

        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>

        <li><a href="../list/list-teacher-schedule">Расписание</a></li>

        <li><a href="../list/list-schedule?id=<?= $idUser; ?>">Расписание

                преподавателя</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<section class="box-body">
    <h3>
        <b>
            <?= $header; ?>
        </b>
    </h3>
</section>
<div class="box-body">
    <?php if (Helper::hasFlash()): ?>
        <div class="alert alert-danger alert-dismissible">

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            <h4><i class="icon fa fa-ban"></i> Ошибка!</h4>
            <?= Helper::getFlash(); ?>
        </div>
    <?php endif; ?>
    <form action="../save/save-schedule" method="POST">
        <div class="form-group">
            <label>Дата</label>
            <input class="form-control" type="date" name="date" required>
        </div>
        <div class="form-group">
            <label>Группа и предмет</label>
            <select class="form-control" name="lesson_plan_id">
                <?= Helper::printSelectOptions(0, (new LessonPlanMap())->arrPlanByTeacherId($idUser)); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Аудитория</label>
            <select class="form-control" name="classroom_id">
                <?= Helper::printSelectOptions(0, (new ClassroomMap())->arrClassrooms()); ?>
            </select>
        </div>
        <input type="hidden" name="user_id" value="<?= $idUser; ?>" />
        <div class="form-group">
            <button type="submit" name="saveSchedule" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>