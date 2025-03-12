<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    header('Location: 404');
}
$header = 'Профиль родителя';
$teacher = (new TeacherMap())->findProfileById($id);
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Профиль родителя</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>

                    <li><a href="../list/list-parent">Родители</a></li>

                    <li class="active">Профиль</li>
                </ol>
            </section>
            <?php if (Helper::can('owner')) { ?>
                <div class="box-body">
                    <a class="btn btn-success" href="../add/add-parent?id=<?= $id; ?>">Изменить</a>
                </div>
            <?php } ?>
            <div class="box-body">

                <table class="table table-bordered table-
hover">

                    <?php require_once '../_profile.php'; ?>

                </table>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>