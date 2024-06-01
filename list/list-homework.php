<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);

} else {
    $page = 1;
}

$studentMap = new StudentMap();
$count = $studentMap->count();
$student = $studentMap->findStudentsFromParent($page * $size - $size, $size);
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
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">Домашнее задание</li>
                </ol>
            </section>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($student) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($student as $student) {
                                echo '<tr>';
                                echo '<td><a href="../view/view-homework?id=' . $student->user_id . '">' . $student->fio . '</a> ' . '</td>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного студента не найдено';
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