<?php
require_once '../secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$manager = (new ManagerMap())->findById($id);
$header = (($id) ? 'Редактировать данные' : 'Добавить') . '
менеджера';
require_once '../template/header.php';
?>
<section class="content-header">
    <h3>
        <b>
            <?= $header; ?>
        </b>
    </h3>
    <ol class="breadcrumb">

        <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

        <li><a href="../list/list-manager">Менеджеры</a></li>

        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-user" method="POST">
        <?php require_once '../_formUser.php'; ?>
        <div class="form-group">
            <button type="submit" name="saveManager" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>