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
$student = (new StudentMap())->findById($id);
$header = (($id) ? 'Редактировать данные' : 'Добавить') . '
Студента';
require_once '../template/header.php';
$_SESSION['temp'] = "student";
?>
<section class="content-header">
    <h3>
        <b>
            <?= $header; ?>
        </b>
    </h3>
    <ol class="breadcrumb">

        <li><a href="../index.php"><i class="fa fa-
dashboard"></i> Главная</a></li>

        <li><a href="../list/list-student.php">Студенты</a></li>

        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-user" method="POST">
        <?php require_once '../_formUser.php'; ?>
        <div class="form-group">
            <label>Группа</label>
            <select class="form-control" name="gruppa_id">
                <?= Helper::printSelectOptions($student->gruppa_id, (new GruppaMap())->arrGruppas()); ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="saveStudent" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>