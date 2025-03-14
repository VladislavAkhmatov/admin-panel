<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$header = 'Профиль администратора';
$admin = (new AdminMap())->findProfileById($id);
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Профиль администратора</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                    <li><a href="../list/list-admin">администратора</a></li>

                    <li class="active">Профиль</li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (Helper::can('admin')) { ?>
                    <a class="btn btn-success" href="../add/add-admin?id=<?= $id; ?>">Изменить</a>
                <?php } ?>

            </div>
            <div class="box-body">

                <table class="table table-bordered table-
hover">

                    <?php require_once '../_profile.php'; ?>

                    <tr>
                        <th>Филиал</th>
                        <td>
                            <?= $admin->branch ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>