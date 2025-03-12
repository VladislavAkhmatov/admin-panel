<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}

$message = 'Посмотреть оценки';

switch ($_GET['message']) {
    case 'ok':
        $message = '<span style="color: green;">Успешно</span>';
        break;
    case 'err':
        $message = '<span style="color: red;">Ошибка</span>';
        break;
}
require_once 'template/header.php';

?>
<section class="content-header">
    <h3>
        <b>
            <?= $message; ?>
        </b>
    </h3>
    <ol class="breadcrumb">

        <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

        <li>Оценки</li>


    </ol>
</section>
<div class="box-body">
    <div class="form-group">
        <form method="GET" action="list/list-students-grades">
            <div class="form-group">
                <label>Дата</label>
                <input class="form-control" type="date" name="date" required>
            </div>
            <div class="form-group">
                <label>Предмет</label>
                <select class="form-control" name="subject_id">
                    <?php Helper::printSelectOptions(0, (new SubjectMap)->arrSubjects()) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Группа</label>
                <select class="form-control" name="gruppa_id">
                    <?php Helper::printSelectOptions(0, (new GruppaMap)->arrGruppas()) ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Применить</button>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="redirectToAnotherPage()">Экспортировать в
                    Excel</button>
            </div>
        </form>
    </div>
</div>
<script>
    function redirectToAnotherPage() {
        var date = document.querySelector('input[name="date"]').value;
        var subject_id = document.querySelector('select[name="subject_id"]').value;
        var gruppa_id = document.querySelector('select[name="gruppa_id"]').value;
        var url = 'excel?date=' + date + '&subject_id=' + subject_id + '&gruppa_id=' + gruppa_id;
        window.location.href = url;
    }
</script>
<?php

require_once 'template/footer.php';
?>