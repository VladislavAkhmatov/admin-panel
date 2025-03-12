<?php
require_once('../secure.php');
ob_start();
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit;
}

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$special = (new SpecialMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление предмета в назначенное время</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-subject"><i class="fa
fa-dashboard"></i> Список времени</a></li>
        <li>Удаление предмета в назначенное время</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить предмет в назначенное время:</p>
        <b style="font-size: 18px;">
            <?= $special->subject; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deletespecial" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deletespecial'])) {
    if ((new SpecialMap())->deleteSpecialById($id)) {
        header('Location: ../list/list-time?message=ok');
        exit();
    } else {
        header('Location: ../list/list-time?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>