<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin') && !Helper::can('teacher')) {
    header('Location: 404.php');
    exit();
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);

} else {
    $page = 1;
}
$teacherMap = new TeacherMap();
$count = $teacherMap->count();
$teachers = $teacherMap->findAll($page * $size - $size, $size);

require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b>
                            <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список учителей' ?>
                        </b></h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                        <li class="active">Список
                            учителей
                        </li>
                    </ol>
                </section>
                <div class="box-body">
                    <?php if (!Helper::can('teacher')): ?>
                        <a class="btn btn-success" href="../add/add-teacher">Добавить преподавателя</a>
                    <?php endif; ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php
                    if ($teachers) {
                        ?>

                        <table id="example2" class="table table-bordered table-hover">

                            <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Дата рождения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($teachers as $teacher) {
                                echo '<tr>';
                                if (!Helper::can('teacher')):
                                    echo '<td><a href="../profile/profile-teacher?id=' . $teacher->user_id . '">' . $teacher->fio . '</a> ' . '<a href="../add/add-teacher?id=' . $teacher->user_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-teacher?id=' . $teacher->user_id . '"><i class="fa fa-times"></i></a></td>';
                                else:
                                    echo '<td><p href="../profile/profile-teacher?id=' . $teacher->user_id . '">' . $teacher->fio . '</p> ' . ' </td>';
                                endif;
                                echo '<td>' . Helper::formattedData($teacher->birthday) . '</td>';
                                echo '</tr>';

                            }
                            ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo 'Ни одного преподавателя не найдено';
                    } ?>
                </div>
                <div class="box-body">
                    <?php Helper::paginator($count, $page, $size); ?>
                </div>
            </div>
        </div>
    </div>
<?php
require_once '../template/footer.php';
?>