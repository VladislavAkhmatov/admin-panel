<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$header = 'Добавить филиал: ';
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

        <li><a href="../list/list-branch">Филиалы</a></li>

        <li class="active">
            <?= $header; ?>
        </li>

    </ol>
</section>
<div class="box-body">
    <form action="../save/save-branch" method="POST">
        <div class="form-group">
            <label>Название филиала</label>
            <input class="form-control" type="text" name="branch">
        </div>

        <div class="form-group">
            <button type="submit" name="saveBranch" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>