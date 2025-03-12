<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$size = 5;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$classroomMap = new ClassroomMap();
$count = $classroomMap->count();
$arrClassrooms = $classroomMap->findAll($page * $size - $size, $size);
$header = 'Список кабинетов';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список кабинетов'; ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fafa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <div class="box-body">
                <a class="btn btn-success" href="../add/add-classroom">Добавить кабинет</a>
            </div>
            <div class="box-body">
                <?php
                if ($arrClassrooms) {
                    ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Название</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($arrClassrooms as $classroom) {
                                echo '<tr>';
                                echo '<td><a href="../view/view-classroom?id=' . $classroom->classroom_id . '">' . $classroom->name . '</a> '
                                    . '<a href="../add/add-classroom?id=' . $classroom->classroom_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-classroom?id=' . $classroom->classroom_id . '"><i class="fa fa-times"></i></a></td>';
                                echo '</tr>';

                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного кабинета не найдено';
                } ?>
            </div>
            <div class="box-body">
                <?php Helper::paginator(
                    $count,
                    $page,
                    $size
                ); ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>