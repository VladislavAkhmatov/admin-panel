<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager') && !Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    header('Location: 404');
}
$header = 'Профиль студента';

$student = (new StudentMap())->findProfileById($id);

$reference = (new StudentMap())->findReferenceById($id);

require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Профиль студента</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                    <li><a href="../list/list-student">Студенты</a></li>

                    <li class="active">Профиль</li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (Helper::can('admin')) { ?>
                    <a class="btn btn-success" href="../add/add-student?id=<?= $id; ?>">Изменить</a>
                <?php } ?>

            </div>
            <div class="box-body">

                <table class="table table-bordered table-hover">

                    <?php require_once '../_profile.php'; ?>

                    <tr>

                        <th>Группа</th>

                        <td>
                            <?= $student->gruppa; ?>
                        </td>


                    </tr>

                    <tr>

                        <th>Справки</th>

                        <td>
                            <?php
                            foreach ($reference as $item) {
                                echo '<a href="../references/' . $item->reference . '">' . $item->reference . ' ' . '</a>';
                            }
                            ?>
                        </td>


                    </tr>

                    <?php if (Helper::can('manager')) { ?>
                        <tr>
                            <th>Филиал</th>

                            <td>
                                <?= $student->branch; ?>
                            </td>

                        </tr>
                    <?php } ?>

                </table>
            </div>
            <?php
            if (Helper::can('procreator')) {
                ?>
                <div class="box-body">
                    <a href="../add/add-avatar?id=<?= $id ?>" class="btn btn-primary">Изменить фото</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>