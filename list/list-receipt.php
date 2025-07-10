<?php

require_once "../secure.php";
if (!Helper::can("owner")) {
    header('Location: 404');
    exit;
}
$size = 10;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$header = 'Квитанции';
$receipts = (new ReceiptMap())->findAll($page * $size - $size, $size);
if (isset($_POST['checked'])) {
    $id = $_POST['id'];
    if ((new ReceiptMap())->checked($id)) {
        Header('Location: list-receipt?q=ok');
        exit();
    } else {
        Header('Location: list-receipt?q=err');
        exit();
    }
}
require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                        <li class="active"><?php echo $header; ?></li>
                        </li>
                    </ol>
                </section>
                <section class="content-header">
                    <h3><b>
                            <?= $header = isset ($_GET['message']) ? Helper::message($_GET['message']) : $header; ?>
                        </b></h3>
                </section>
                <section class="content-header">
                    <div class="box-body">
                        <?php
                        if ($receipts) {
                            ?>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Тип квитанции</th>
                                    <th>Примечание</th>
                                    <th>Файл</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($receipts as $receipt): ?>
                                    <tr>
                                        <td><?php echo $receipt->type == 1 ? 'Чек' : 'Возврат' ?></td>
                                        <td><?php echo $receipt->note ?></td>
                                        <td><?php echo "<a href='$receipt->file'>" . basename(substr(stristr($receipt->file, '_'), 1)) . "</a>" ?></td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $receipt->id ?>">
                                                <button name="checked" type="submit" class="btn btn-primary">Проверено
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo 'Ни одной квитанции не найдено';
                        } ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php


require_once "../template/footer.php";
?>