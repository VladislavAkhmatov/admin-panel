<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
    $gruppa = (new GruppaMap())->findViewById($id);
    $header = 'Просмотр группы';
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
gruppa">Группы</a></li>

                        <li class="active">
                            <?= $header; ?>
                        </li>
                    </ol>
                </section>
                <div class="box-body">
                    <?php if (Helper::can('admin')) { ?>
                        <a class="btn btn-success" href="../add/add-gruppa?id=<?= $id; ?>">Изменить</a>
                    <?php }
                    ; ?>
                </div>
                <div class="box-body">

                    <table class="table table-bordered table-
hover">

                        <tr>
                            <th>Название</th>

                            <td>
                                <?= $gruppa->name; ?>
                            </td>

                        </tr>

                        <tr>

                            <th>Дата образования</th>
                            <td>
                                <?= date("d.m.Y", strtotime($gruppa->date_begin)); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Дата окончания</th>
                            <td>
                                <?= date("d.m.Y", strtotime($gruppa->date_end)); ?>
                            </td>
                        </tr>
                        <?php if (Helper::can('manager')) { ?>
                            <tr>

                                <th>Филиал</th>

                                <td>
                                    <?= $gruppa->branch; ?>
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