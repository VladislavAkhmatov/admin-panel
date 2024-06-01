<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}


$subject = (new SubjectMap())->findById($id);
$header = (($id) ? 'Редактировать' : 'Добавить') . ' предмет';
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

        <li><a href="../list/list-subject">Предметы</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-subject" method="POST">
        <div class="form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="required" value="<?= $subject->name; ?>">
        </div>
        <div class="form-group">
            <label>Отдел</label>
            <select class="form-control" name="otdel_id">
                <?= Helper::printSelectOptions($subject->otdel_id, (new OtdelMap())->arrOtdels()); ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="saveSubject" class="btn btn-primary">Сохранить</button>
        </div>
        <input type="hidden" name="subject_id" value="<?= $id; ?>" />
    </form>
</div>
<?php
require_once '../template/footer.php';
?>