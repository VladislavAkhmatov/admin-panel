<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$header = 'Добавить ученика к родителю: ';
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

        <li><a href="../list/list-parent">Родители</a></li>

        <li class="active">
            <?= $header; ?>
        </li>

    </ol>
</section>
<div class="box-body">
    <form action="../save/save-child-parent" method="POST">
        <div class="form-group">
            <label>Родитель</label>
            <select class="form-control" name="user_id">
                <?= Helper::printSelectOptions(0, (new ProcreatorMap())->arrParents()); ?>
            </select>
        </div>

        <div class="form-group">
            <label>Ученик</label>
            <select class="form-control" name="child_id">
                <?= Helper::printSelectOptions(0, (new StudentMap())->arrStudents()); ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="saveChildParent" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<?php
require_once '../template/footer.php';
?>