<?php
require_once 'secure.php';
if (!Helper::can('manager')) {
    header('Location: 404');
    exit();
}

$id = 0;
$subject_id = 0;
$parent_id = 0;
$child_id = 0;
$subject_count = 0;
$subject_price = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $subject_id = $_GET['subject_id'];
    $parent_id = $_GET['parent_id'];
    $child_id = $_GET['child_id'];
    $subject_count = $_GET['count'];
    $subject_price = $_GET['price'];
}
$userMap = new UserMap();

require_once 'template/header.php';
?>
<section class="content-header">
    <h3>
        <b>
            <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Создать оплату'; ?>
        </b>
    </h3>
    <ol class="breadcrumb">
        <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li>Создать оплату</li>
    </ol>
</section>
<div class="box-body">
    <div class="form-group">
        <form action="save/save-paymentArchive" method="POST">
            <div class="form-group">
                <label>Причина отмены</label>
                <input class="form-control" type="text" name="text">
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
                <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
                <input type="hidden" name="child_id" value="<?= $child_id ?>">
                <input type="hidden" name="subject_count" value="<?= $subject_count ?>">
                <input type="hidden" name="subject_price" value="<?= $subject_price ?>">
                <button type="submit" name="paymentDelete" class="btn btn-primary">Отклонить</button>
            </div>
        </form>
    </div>
</div>
<?php

require_once 'template/footer.php';
?>