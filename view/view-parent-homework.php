<?php
require_once '../secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$teacherMap = new TeacherMap();
$teacher = $teacherMap->findHomeworkByGruppaIdAndTeacherId($id);

$header = 'Список студентов';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Домашнее задание'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="/index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">Домашнее задание</li>
                </ol>
            </section>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($teacher) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($teacher as $teacher) {
                                echo '<tr>';
                                echo '<td><a href="../parent-homework?id=' . $teacher->homework_id . '">' . $teacher->student_fio . ' &#10140; ' . $teacher->name . '</a> ' . '</td>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного студента не найдено';
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';

?>