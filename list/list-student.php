<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin') && !Helper::can('teacher')) {
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
$student = $studentMap->findAll($page * $size - $size, $size);



require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список учеников'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список
                        учеников</li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (!Helper::can('teacher')): ?>
                    <a class="btn btn-success" href="../add/add-student">Добавить ученика</a>
                    <a class="btn btn-success" href="../add/add-subjectForStudent">Добавить предмет к ученику</a>
                <?php endif; ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($student) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Дата рождения</th>
                                <th>Группа</th>
                                <th>Предмет(ы)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($student as $student) {
                                echo '<tr>';
                                if (!Helper::can('teacher')):
                                    echo '<td><a href="../profile/profile-student?id=' . $student->user_id . '">' . $student->fio . '</a> ' . '<a href="../add/add-student?id=' . $student->user_id . '"><i class="fa fa-pencil"></i></a>  <a href="../delete/delete-student?id=' . $student->user_id . '"><i class="fa fa-times"></i></a></td>';
                                else:
                                    echo '<td><p href="../profile/profile-student?id=' . $student->user_id . '">' . $student->fio . '</p> ' . '</i></a></td>';
                                endif;
                                echo '<td>' . $student->birthday . '</td>';
                                echo '<td>' . $student->gruppa . '</td>';
                                echo '<td>';
                                $subjects = (new StudentMap())->findStudentSubjectsByUserId($student->user_id);
                                $subject_names = array();
                                foreach ($subjects as $item) {
                                    $subject_names[] = trim($item->name);
                                }
                                $subject = implode(', ', $subject_names);
                                echo $subject;
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного ученика не найдено';
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