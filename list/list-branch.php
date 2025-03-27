<?php

require_once "../secure.php";

if (!Helper::can("owner")) {
    header('Location: 404');
    exit;
}
$branches = (new BranchMap())->arrBranches();
require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                        <li class="active">Список
                            администраторов
                        </li>
                    </ol>
                </section>
                <section class="content-header">
                    <h3><b>
                            <?= $header = isset ($_GET['message']) ? Helper::message($_GET['message']) : 'Список филиалов' ?>
                        </b></h3>
                </section>
                <section class="content-header">
                    <a class="btn btn-success" href="../add/add-branch"> Добавить филиал</a>
                </section>
                <section class="content-header">
                    <div class="box-body">
                        <?php
                        if ($branches) {
                            ?>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($branches as $branch) {
                                    echo '<tr>';
                                    echo '<td><span>' . $branch['value'] . '</span> '
                                        . '<a href="../add/add-branch?id=' . $branch['id'] . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-branch?id=' . $branch['id'] . '"><i class="fa fa-times"></i></a></td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo 'Ни одного филиала не найдено';
                        } ?>
                    </div>
                </section>

            </div>
        </div>
    </div>
<?php
require_once "../template/footer.php";
?>