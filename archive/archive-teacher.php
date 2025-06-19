<?php
require_once "../secure.php";
if (!Helper::can('admin') && !Helper::can('owner')) {
    header("Location: 404");
    exit();
}
$header = "Архив преподавателей";
$size = 5;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$teachers = (new TeacherMap())->findAllArchive($page * $size - $size, $size);
$count = count($teachers);
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $header = isset($_GET['message']) ? Helper::message($_GET['message']) : $header ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active"><?php echo $header ?></li>
                   
                    </li>
                </ol>
            </section>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($teachers) {
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
                        foreach ($teachers as $teacher) {
                            echo '<tr>';
                            echo '<td><a href="../profile/profile-teacher?id=' . $teacher->user_id . '">' . $teacher->fio . '</a> ' . '<a href="../delete/delete-teacher?id=' . $teacher->user_id . '&archive=1"><i class="fa fa-times"></i></a></td>';
                            echo '<td>' . $teacher->gender . '</td>';
                            echo '<td>' . Helper::formattedData($teacher->birthday) . '</td>';
                            if (Helper::can('admin'))
                                echo '<td>' . $teacher->branch_name . '</td>';
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
