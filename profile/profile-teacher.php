<?php
require_once '../secure.php';
if (Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
if (isset ($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    header('Location: 404');
}
$header = 'Профиль преподавателя';
$teacher = (new TeacherMap())->findProfileById($id);
require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b>Профиль преподавателя</b></h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                        <li><a href="../list/list-teacher">Преподаватели</a></li>

                        <li class="active">Профиль</li>
                    </ol>
                </section>
                <div class="box-body">
                    <?php if (Helper::can('owner')) { ?>
                        <a class="btn btn-success" href="../add/add-teacher?id=<?= $id; ?>">Изменить</a>
                    <?php } ?>

                </div>
                <div class="box-body">

                    <table class="table table-bordered table-
hover">

                        <?php require_once '../_profile.php'; ?>

                        <tr>

                            <th>Зарплата</th>

                            <td>
                                <?= $teacher->salary ?? ''; ?>
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