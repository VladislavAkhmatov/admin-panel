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
$classroom = (new ClassroomMap())->findById($id);
$header = (($id) ? 'Редактировать' : 'Добавить') . ' кабинет';
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

        <li><a href="../list/list-classroom">Кабинеты</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-classroom" method="POST">
        <div class="form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="required" value="<?= $classroom->name; ?>">
        </div>
        <div class="form-group">
            <label>Заблокировать</label>
            <div class="radio">
                <label>
                    <input type="radio" name="active" value="1" <?= ($user->active) ? 'checked' : ''; ?>> Нет
                </label> &nbsp;
                <label>
                    <input type="radio" name="active" value="0" <?= (!$user->active) ? 'checked' : ''; ?>> Да
                </label>
            </div>
            <div class="form-group">
                <button type="submit" name="saveClassroom" class="btn btn-primary">Сохранить</button>
            </div>
            <input type="hidden" name="classroom_id" value="<?= $id; ?>" />
    </form>
</div>
<?php
require_once '../template/footer.php';
?>