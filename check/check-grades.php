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

if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    $id = 1;
}

$studentMap = new StudentMap();
$count = $studentMap->count();
$students = $studentMap->checkgrades();
$header = 'Список студентов';
require_once '../template/header.php';


?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список оценок'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список оценок</li>

                </ol>
            </section>
            <div class="box-body">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($students) { ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Предмет</th>
                                <th>Оценка</th>
                                <th>Дата</th>
                                <th>Посещаемость</th>
                                <th>Комментарий</th>
                                <th>Дом. задание</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($students as $student) {
                                echo "<tr>";
                                echo "<td>" . $student->fio . "</td>";
                                echo "<td>" . $student->subject . "</td>";
                                echo "<td>" . $student->grade . "</td>";
                                echo "<td>" . $student->date . "</td>";
                                echo "<td>" . $student->attend . "</td>";
                                echo "<td>" . $student->comment . "</td>";
                                echo "<td> <a href='../homework-student/" . $student->homework . "'>" . preg_replace("/^[0-9_]+/", "", $student->homework) . "</a></td>";
                                echo "<td>" . '<form action="../save/save-grades" method="post">
                                                        <input type="hidden" name="grade_id" value="' . $student->id . '">
                                                        <input type="hidden" name="user_id" value="' . $student->user_id . '">
                                                        <input type="hidden" name="subject_id" value="' . $student->subject_id . '">
                                                        <input type="hidden" name="grade" value="' . $student->grade . '">
                                                        <input type="hidden" name="date" value="' . $student->date . '">
                                                        <input type="hidden" name="attend" value="' . $student->attend_id . '">
                                                        <input type="hidden" name="comment" value="' . $student->comment . '">
                                                        <input type="hidden" name="homework" value="' . $student->homework . '">
                                                        <input class="btn btn-success" type="submit" name="gradesSubmit" value="Подтвердить">
                                                        <input class="btn btn-danger" type="submit" name="gradesDelete" value="Отклонить">
                                                        </form>' . "</td>";

                                echo "</tr>";
                            }
                } else {
                    echo 'Оценок на подтверждение не найдено';
                }

                ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php';
?>