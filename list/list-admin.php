<?php
require_once '../secure.php';
if (!Helper::can('owner')) {
    header('Location: 404');
    exit();
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);

} else {
    $page = 1;
}
$adminMap = new AdminMap();
$count = $adminMap->count();
$admins = $adminMap->findAll($page * $size - $size, $size);
$header = 'Список администраторов';
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
                        администраторов</li>
                </ol>
            </section>
            <div class="box-body">
                <a class="btn btn-success" href="../add/add-admin">Добавить администратора</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($admins) {
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
                            foreach ($admins as $admin) {
                                echo '<tr>';
                                echo '<td><a href="../profile/profile-admin?id=' . $admin->user_id . '">' . $admin->fio . '</a> ' . '<a href="../add/add-admin?id=' . $admin->user_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-admin?id=' . $admin->user_id . '"><i class="fa fa-times"></i></a></td>';
                                echo '<td>' . $admin->gender . '</td>';
                                echo '<td>' . Helper::formattedData($admin->birthday) . '</td>';
                                if (Helper::can('admin'))
                                    echo '<td>' . $admin->branch_name . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного администратора не найдено';
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