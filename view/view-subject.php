<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
    $subject = (new SubjectMap())->findViewById($id);
    $header = 'Просмотр предметов';
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
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                        <li><a href="../list/list-
subject">Предметы</a></li>

                        <li class="active">
                            <?= $header; ?>
                        </li>
                    </ol>
                </section>
                <div class="box-body">
                    <?php if (Helper::can('owner')) { ?>
                        <a class="btn btn-success" href="../add/add-subject?id=<?= $id; ?>">Изменить</a>
                    <?php }; ?>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-
hover">
                        <tr>
                            <th>Предмет</th>

                            <td>
                                <?= $subject->name; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
}
require_once '../template/footer.php';
?>