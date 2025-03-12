<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$teacher = (new TeacherMap())->findById($id);
$header = (($id) ? 'Редактировать данные' : 'Добавить') . '
преподавателя';
require_once '../template/header.php';
?>
<section class="content-header">
    <h3>
        <b>
            <?= $header; ?>
        </b>
    </h3>
    <ol class="breadcrumb">

        <li><a href="../index"><i class="fa fa-
dashboard"></i> Главная</a></li>

        <li><a href="../list/list-
teacher">Преподаватели</a></li>

        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-user" method="POST" enctype="multipart/form-data">
        <?php require_once '../_formUser.php'; ?>
        <div class="form-group">
            <label>Дисциплина</label>
            <select class="form-control" name="subject_id">
                <?= Helper::printSelectOptions($teacher->subject_id, (new SubjectMap())->arrSubjects()); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Достижение</label>
            <input type="text" class="form-control" name="award" value="<?= $teacher->award ?>">
        </div>

        <div class="form-group">
            <button type="submit" name="saveTeacher" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>