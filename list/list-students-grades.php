<?php
require_once '../secure.php';
ob_start();
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$subject_id = 0;
$date = '';
$gruppa_id = 0;
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $date = $_GET['date'];
    $gruppa_id = $_GET['gruppa_id'];
}

$gradesMap = new GradeMap();
$grades = $gradesMap->findBySubjectId($date, $subject_id, $gruppa_id);

$header = 'Список студентов';
$attend = '';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Список оценок</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список
                        оценок</li>
                </ol>
            </section>
            <div class="box-body">
                <?php
                if ($grades) {
                    ?>
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
                                foreach ($grades as $grade) {
                                    if ($grade->attend == 0) {
                                        $attend = 'Н';
                                    } else {
                                        $attend = 'Б';
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $grade->fio . '</td>';
                                    echo '<td>' . $grade->subject . '</td>';
                                    echo '<td>' . $grade->grade . ' ' . $attend . '</td>';
                                    echo '<td>' . $grade->date . '</td>';
                                    if ($grade->attend == 0) {
                                        echo '<td>
                                    <select style="width: 150px" class="form-control" name="reason[' . $grade->id . ']"> 
                                        <option value="0">Не ув. причина</option>
                                        <option value="1">Ув. причина</option>
                                    </select>
                                        </td>';
                                    }
                                    echo '</tr>';

                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" name="saveReason" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                <?php } else {
                    echo 'Ни одной оценки не найдено';
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['saveReason'])) {
    $count = 0;
    foreach ($_POST['reason'] as $item => $grades->id) {
        $grades = new Grade();
        $grades->reason = $_POST['reason'][$item];
        $id = $item;
        if ((new GradeMap)->insertReason($grades, $id)) {
            $count += 1;
        }
    }

    if (count($_POST['reason']) == $count) {
        header('Location: ../select-subject?message=ok');
        exit();
    } else {
        header('Location: ../select-subject?message=err');
        exit();
    }
}
ob_end_flush();
require_once '../template/footer.php';
?>