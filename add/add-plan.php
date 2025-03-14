<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404.php');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
if ((new TeacherMap())->findById($id)) {
    $teacher = (new UserMap())->findProfileById($id);
} else {
    header('Location: 404');
}
$header = 'Добавить пункт в план: ' . $teacher->fio;
require_once '../template/header.php';
?>
<section class="content-header">
    <h3>
        <b>
            <?= $header; ?>
        </b>
    </h3>
    <ol class="breadcrumb">

        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>

        <li><a href="../list/list-teacher-schedule">Расписание</a></li>

        <li><a href="../list/list-plan?id=<?= $id; ?>">План
                преподавателя</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <?php if (Helper::hasFlash()): ?>
        <div class="alert alert-danger alert-dismissible">

            <button type="button" class="close" data- dismiss="alert" aria-hidden="true">&times;</button>

            <h4><i class="icon fa fa-ban"></i> Ошибка!</h4>

            <?= Helper::getFlash(); ?>
        </div>
    <?php endif; ?>
    <form action="../save/save-plan" method="POST">
        <div class="form-group">
            <label>Группа</label>
            <select class="form-control" name="gruppa_id">
                <?= Helper::printSelectOptions(0, (new GruppaMap())->arrGruppas()); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Предмет</label>
            <select class="form-control" name="subject_id">
                <?= Helper::printSelectOptions(0, (new SpecialMap())->arrSubjectsTime()); ?>
            </select>
        </div>
        <input type="hidden" name="user_id" value="<?= $id; ?>" />
        <div class="form-group">
            <button type="submit" name="savePlan" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>