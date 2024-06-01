<?php
require_once '../secure.php';



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
$student = $studentMap->findStudentByControl($id);
$header = 'Список студентов';
require_once '../template/header.php';

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Количество занятий</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Количество занятий</li>
                </ol>
            </section>
            <div class="box-body">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($student) { ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Предмет</th>
                                <th>Количество уроков</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($student as $student) {
                                echo '<tr>';
                                echo '<td><p>' . $student->fio . '</p></td>';
                                echo '<td><p>' . $student->subject . '</p></td>';
                                echo '<td><p>' . $student->count . '</p></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Отсутвуют занятия для этого ученика';
                } ?>
            </div>

        </div>
    </div>
</div>
<script>
    function calculateSum() {
        var input1 = parseFloat(document.getElementById("input1").value);

        if (isNaN(input1) || input1 < 0) {
            document.getElementsByName("subject_price")[0].value = 0;
            document.getElementById("sum").textContent = 0 + "₸";
        }
        else if (sum != 0) {
            var sum = input1 * 5000;
            document.getElementsByName("subject_price")[0].value = sum;
            document.getElementById("sum").textContent = sum + "₸";
        }
    }
</script>
<?php
require_once '../template/footer.php';

?>