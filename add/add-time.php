<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset ($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$special = (new SpecialMap())->findById($id);
$header = (($id) ? 'Редактировать' : 'Добавить') . ' время';
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

        <li><a href="../list/list-time">Время</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-special" method="POST">
        <div class="form-group">
            <label>Предмет</label>
            <select class="form-control" name="subject_id" required="required">
                <?= Helper::printSelectOptions($special->subject_id, (new SubjectMap())->arrSubjects()) ?>
            </select>
        </div>
        <div class="form-group">
            <label>Начало занятия</label>
            <input class="form-control" name="time_begin" type="time">
        </div>
        <div class="form-group">
            <label>Конец занятия</label>
            <input class="form-control" name="time_end" type="time">
        </div>
        <div class="form-group">
        </div>
        <div class="form-group">
            <button type="submit" name="saveSpecial" class="btn btn-primary">Сохранить</button>
        </div>
        <input type="hidden" name="special_id" value="<?= $id; ?>" />
    </form>
</div>
<?php
require_once '../template/footer.php';
?>