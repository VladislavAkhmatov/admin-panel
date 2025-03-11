<?php
require_once '../secure.php';

$id = 0;
$canceled = 0;
$size = 10;

if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
    $canceled = Helper::clearInt($_GET['canceled']);
}
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}

$procreatorMap = new ProcreatorMap();
$notice = $procreatorMap->findNoticeById($id);
require_once '../template/header.php';
$header = "Оплата";
?>

<section class="content-header">
    <h3><b>
            <?= $header ?>
        </b></h3>
    <ol class="breadcrumb">
        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Оплата</li>
    </ol>
</section><br>
<?php
if ($canceled == 0) {
    ?>
    <form action="../save/save-payment" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Текст уведомления</th>
                    <td>
                        <?= $notice->text ?>
                    </td>
                </tr>
                <tr>
                    <th>Предмет</th>
                    <td>
                        <?= $notice->subject ?>
                    </td>
                </tr>
                <tr>
                    <th>За кого</th>
                    <td>
                        <?= $notice->fio ?>
                    </td>
                </tr>
                <tr>
                    <th>Количество занятий</th>
                    <td>
                        <?= $notice->subject_count ?>
                    </td>
                </tr>
                <tr>
                    <th>Цена</th>
                    <td>
                        <?= $notice->subject_price ?>
                    </td>
                </tr>
                <tr>
                    <th>Ссылка</th>
                    <td>
                        <a href="<?= $notice->link ?>">
                            <?= $notice->link ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>До</th>
                    <td>
                        <?= $notice->date; ?>
                    </td>
                </tr>
                <tr>
                    <th>Чек</th>
                    <td>
                        <input type="file" name="tab" required>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="child_id" value="<?= $notice->child_id ?>">
            <input type="hidden" name="subject_id" value="<?= $notice->subject_id ?>">
            <input type="hidden" name="subject_count" value="<?= $notice->subject_count ?>">
            <input type="hidden" name="subject_price" value="<?= $notice->subject_price ?>">
            <input type="hidden" name="link" value="<?= $notice->link ?>">
            <input type="hidden" name="id" value="<?= $notice->id ?>">
            <br>
            <input class="btn btn-primary" type="submit" name="savePayment" value="Оплатить">
        </div>
    </form>

    <?php
} else {
    ?>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Текст уведомления</th>
            <td>
                <?= $notice->text ?>
            </td>
        </tr>
        <tr>
            <th>Предмет</th>
            <td>
                <?= $notice->subject ?>
            </td>
        </tr>
        <tr>
            <th>За кого</th>
            <td>
                <?= $notice->fio ?>
            </td>
        </tr>
        <tr>
            <th>Количество занятий</th>
            <td>
                <?= $notice->subject_count ?>
            </td>
        </tr>
        <tr>
            <th>Цена</th>
            <td>
                <?= $notice->subject_price ?>
            </td>
        </tr>
        <tr>
            <th>Чек</th>
            <td>
                <input type="file" name="tab" required>
            </td>
        </tr>
    </table>
    <?php
}
require_once '../template/footer.php';

?>