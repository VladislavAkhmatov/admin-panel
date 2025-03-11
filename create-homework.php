<?php
require_once 'secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$userMap = new UserMap();
require_once 'template/header.php';
?>

<section class="content-header">
    <h3>
        <b>
            <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Создать домашнее задание'; ?>
        </b>
    </h3>
    <ol class="breadcrumb">
        <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li>Уведомления</li>
    </ol>
</section>
<br>
<form action="save/save-homework-teacher" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Тема задания</label>
        <input class="form-control" type="text" name="name">
    </div>

    <div class="form-group">
        <label>Для группы</label>
        <select class="form-control" name="gruppa_id">
            <?php Helper::printSelectOptions(0, (new GruppaMap())->arrGruppas()) ?>
        </select>
    </div>

    <div class="form-group">
        <label>Начать выполнение с</label>
        <input type="date" class="form-control" name="date_begin">
    </div>

    <div class="form-group">
        <label>Закончить до</label>
        <input type="date" class="form-control" name="date_end">
    </div>

    <div class="form-group">
        <label>Предмет</label>
        <select class="form-control" name="subject_id">
            <?php Helper::printSelectOptions(0, (new StudentMap())->arrSubjectFromBranch()) ?>
        </select>
    </div>

    <div class="form-group">
        <label>Файл с заданием</label>
        <input type="file" name="file">
    </div>

    <div class="form-group">
        <button type="submit" name="saveHomeworkTeacher" class="btn btn-primary">Сохранить</button>
    </div>
</form>


</div>
<?php
require_once 'template/footer.php';
?>