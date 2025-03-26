<?php
require_once '../secure.php';

$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
} else {
    header('Location: 404');
}

$studentMap = new StudentMap();
$student = $studentMap->findStudentById($id);

$balanceMap = new BalanceMap();
$balances = $balanceMap->findByUserId($id);
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
                        <li><?= $student->fio ?></li>
                        <li class="active">Баланс уроков</li>
                    </ol>
                </section>
                <div class="box-body">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if ($balances): ?>
                        <div class="container mt-4">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Предмет</th>
                                    <th>Количество уроков</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($balances as $balance): ?>
                                    <tr>
                                        <td><?= $balance->subject ?></td>
                                        <td><?= $balance->count ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="container">
                            <p>Ни одной оценки не найдено</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php
require_once '../template/footer.php';
?>