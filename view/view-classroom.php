<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
    $classroom = (new ClassroomMap())->findViewById($id);
    $header = 'Просмотр отдел';
    require_once '../template/header.php';
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3>
                        <b>
                            <?= $header; ?>
                        </b>
                    </h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fafa-dashboard"></i> Главная</a></li>
                        <li><a href="../list/list-classroom">Аудитория</a></li>

                        <li class="active">
                            <?= $header; ?>
                        </li>
                    </ol>
                </section>
                <div class="box-body">
                    <?php if (Helper::can('owner')) { ?>
                        <a class="btn btn-success" href="../add/add-classroom?id=<?= $id; ?>">Изменить</a>
                    <?php }
                    ; ?>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Название</th>
                            <td>
                                <?= $classroom->name; ?>
                            </td>
                        </tr>
                        <?php if (Helper::can('admin')) { ?>
                            <tr>
                                <th>Филиал</th>
                                <td>
                                    <?= $classroom->branch; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
}
require_once '../template/footer.php';
?>