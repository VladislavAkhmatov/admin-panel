<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$header = 'Профиль менеджера';
$manager = (new ManagerMap())->findProfileById($id);
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Профиль менеджера</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                    <li><a href="../list/list-manager">Менеджеры</a></li>

                    <li class="active">Профиль</li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (Helper::can('manager')) { ?>
                    <a class="btn btn-success" href="../add/add-manager?id=<?= $id; ?>">Изменить</a>
                <?php } ?>

            </div>
            <div class="box-body">

                <table class="table table-bordered table-
hover">

                    <?php require_once '../_profile.php'; ?>

                    <tr>
                        <th>Филиал</th>
                        <td>
                            <?= $manager->branch ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                <a href="../add/add-avatar?id=<?= $id ?>" class="btn btn-primary">Изменить фото</a>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>