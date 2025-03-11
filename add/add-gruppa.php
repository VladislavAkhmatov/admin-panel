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
$gruppa = (new GruppaMap())->findById($id);
$header = (($id) ? 'Редактировать' : 'Добавить') . ' группу';
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

        <li><a href="../list/list-gruppa">Группы</a></li>
        <li class="active">
            <?= $header; ?>
        </li>
    </ol>
</section>
<div class="box-body">
    <form action="../save/save-gruppa" method="POST">
        <div class="form-group">
            <label>Название</label>
            <input type="text" class="form-control" name="name" required="required" value="<?= $gruppa->name; ?>">
        </div>
        <div class="form-group">
            <label>Дата образования</label>
            <input type="date" class="form-control" name="date_begin" required="required"
                value="<?= $gruppa->date_begin; ?>">
        </div>

        <div class="form-group">
            <label>Дата окончания</label>
            <input type="date" class="form-control" name="date_end" required="required"
                value="<?= $gruppa->date_end; ?>">
        </div>
        <div class="form-group">
            <button type="submit" name="saveGruppa" class="btn btn-primary">Сохранить</button>
        </div>
        <input type="hidden" name="gruppa_id" value="<?= $id; ?>" />
    </form>
</div>
<?php
require_once '../template/footer.php';
?>