<?php
require_once '../secure.php';

$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    header('Location: 404');
}

$studentMap = new StudentMap();
$count = $studentMap->count();
$student = $studentMap->findStudentById($id);
$header = 'Список студентов';
require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b>
                            <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : $student->fio; ?>
                        </b></h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li class="active"><?= $student->fio ?></li>
                    </ol>
                </section>
                <div class="box-body">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if ($student): ?>
                        <div class="mb-3">
                            <a href="/check/check-grades?id=<?= $student->user_id ?>"
                               class="btn btn-primary d-block w-100 mb-2">
                                Оценки
                            </a>
                            <a href="/select-schedule" class="btn btn-primary d-block w-100">
                                Расписание
                            </a>
                            <a href="/select-schedule" class="btn btn-primary d-block w-100">
                                Баланс уроков
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php
require_once '../template/footer.php';
?>