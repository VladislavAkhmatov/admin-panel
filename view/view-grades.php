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
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    $id = 1;
}
$studentMap = new StudentMap();
$students = $studentMap->viewGrades();
$header = 'Студент';
$userMap = new UserMap();
$user = $userMap->auth($login, $password);
require_once '../template/header.php';

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Оценки</b></h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> Главная</li>
                </ol>
            </section>
            <div class="box-body">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($students) { ?>
                    <form method="POST">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ф.И.О</th>
                                    <th>Предмет</th>
                                    <th>Оценка</th>
                                    <th>Дата</th>
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
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
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