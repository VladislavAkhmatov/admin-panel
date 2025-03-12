<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
require_once '../template/header.php';
$date = '';
if (!isset ($_GET['date'])) {
    $id = Helper::clearInt($_GET['id']);


    $message = 'Сверка оплаты';

    require_once '../template/header.php';

    ?>
    <section class="content-header">
        <h3>
            <b>
                <?= $message; ?>
            </b>
        </h3>
        <ol class="breadcrumb">

            <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

            <li>Сверка оплаты</li>


        </ol>
    </section>
    <div class="box-body">
        <div class="form-group">
            <form method="GET" action="../view/view-payment">
                <div class="form-group">
                    <label>Дата</label>
                    <input class="form-control" type="date" name="date" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Далее</button>
                </div>

            </form>
        </div>
    </div>
    <?php

} else if (isset ($_GET['date']) && !isset ($_GET['branch'])) {
    $date = $_GET['date'];
    $branch = $_SESSION['branch'];
    if (Helper::can('owner')) {
        $payment = (new ownerMap())->findPaymentByDate($date);
    } else {
        $payment = (new ownerMap())->findPaymentByDateAndBranch($date, $branch);
    }

    $header = 'Список оплаты';
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
                            if (Helper::can('owner')) {
                                ?>

                                <form method="GET" action="view-payment">
                                    <input type="hidden" name="date" value="<?= $date ?>">
                                    <select style="width: 300px;" class="form-control" name="branch">
                                    <?= Helper::printSelectOptions(0, (new UserMap())->arrBranchs()) ?>
                                    </select><br>
                                    <input class="btn btn-primary" type="submit" value="Далее">
                                </form>
                            <?php
                            }
                            ?>
                            <form>
                                <table class="table table-bordered table-hover">
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
} else if (isset ($_GET['date']) && isset ($_GET['branch'])) {
    $date = $_GET['date'];
    $branch = $_GET['branch'];
    $payment = (new ownerMap())->findPaymentByDateAndBranch($date, $branch);

    $header = 'Список оплаты';
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
                                    <table class="table table-bordered table-hover">
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
                    <?php } else { ?>
                                <p>Ни одной оплаты не найдено</p>
                    <?php } ?>
                            <div class="form-group">
                                <a class="btn btn-primary" href="view-payment">Назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
}
require_once '../template/footer.php';
?>