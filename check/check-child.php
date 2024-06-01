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
$students = $studentMap->findStudentById();
$header = 'Список студентов';
require_once '../template/header.php';

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Оплата'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список студентов</li>
                </ol>
            </section>
            <div class="box-body">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($students) { ?>
                    <form action="../save/save-payment" method="POST" enctype="multipart/form-data">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ф.И.О</th>
                                    <th>Предмет</th>
                                    <th>Кол-во уроков</th>
                                    <th>Сумма</th>
                                    <th>Подтвеждение</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="child_id">
                                            <?= Helper::printSelectOptions('', (new ProcreatorMap())->arrChilds()); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="subject_id">
                                            <?= Helper::printSelectOptions($students->subject_id, (new SubjectMap())->arrSubjects()); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<input type="number" name="subject_count" id="input1" oninput="calculateSum()">';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<input type="hidden" name="subject_price">';
                                        echo '<span id="sum"></span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<input  type="file" name="fileToUpload">';
                                        ?>
                                    </td>
                                    <td>
                                        <button type="submit" name="savePayment" class="btn btn-primary">Сохранить</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="user_id" value="<?= $id; ?>" />
                    </form>
                <?php } else {
                    echo 'Cтудент не найден';
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