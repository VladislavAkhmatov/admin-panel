<?php
require_once '../secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);

} else {
    $page = 1;
}
$managerMap = new ManagerMap();
$count = $managerMap->count();
$managers = $managerMap->findAll($page * $size - $size, $size);
$header = 'Список менеджеров';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : $header ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список
                        менеджеров</li>
                </ol>
            </section>
            <div class="box-body">
                <a class="btn btn-success" href="../add/add-manager">Добавить менеджера</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($managers) {
                    ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Пол</th>
                                <th>Дата рождения</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($managers as $manager) {
                                echo '<tr>';
                                echo '<td><a href="../profile/profile-manager?id=' . $manager->user_id . '">' . $manager->fio . '</a> ' . '<a href="../add/add-manager?id=' . $manager->user_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-manager?id=' . $manager->user_id . '"><i class="fa fa-times"></i></a></td>';
                                echo '<td>' . $manager->gender . '</td>';
                                echo '<td>' . $manager->birthday . '</td>';
                                if (Helper::can('manager'))
                                    echo '<td>' . $manager->branch_name . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного менеджера не найдено';
                } ?>
            </div>
            <div class="box-body">
                <?php Helper::paginator($count, $page, $size); ?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>