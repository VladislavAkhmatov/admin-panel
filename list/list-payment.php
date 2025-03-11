<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}

$date = '';
if (isset ($_GET['date'])) {
    $date = $_GET['date'];
}

$payment = (new AdminMap())->findPaymentByDate($date);

$header = 'Список оплаты';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Список оплаты</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список
                        оплаты</li>
                </ol>
            </section>
            <div class="box-body">
                <?php
                if ($payment) {
                    ?>
                    <form method="POST">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ф.И.О родителя</th>
                                    <th>Ф.И.О ученика</th>
                                    <th>Предмет</th>
                                    <th>Кол-во предметов</th>
                                    <th>Цена</th>
                                    <th>Дата</th>
                                    <th>Филиал</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($payment as $item) {
                                    echo '<tr>';
                                    echo '<td>' . $item->parent . '</td>';
                                    echo '<td>' . $item->child . '</td>';
                                    echo '<td>' . $item->subject . '</td>';
                                    echo '<td>' . $item->subject_count . '</td>';
                                    echo '<td>' . $item->subject_price . '</td>';
                                    echo '<td>' . $item->date . '</td>';
                                    echo '<td>' . $item->branch_name . '</td>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                <?php } else {
                    echo 'Ни одной оплаты не найдено';
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>