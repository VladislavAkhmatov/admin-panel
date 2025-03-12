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
$otdel = (new OtdelMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление отдела</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-otdel"><i class="fa
fa-dashboard"></i> Список отделов</a></li>
        <li>Удаление отделов</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить отдел:</p>
        <b style="font-size: 18px;">
            <?= $otdel->name; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteOtdel" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteOtdel'])) {
    if ((new OtdelMap())->deleteOtdelById($id)) {
        header('Location: ../list/list-otdel?message=ok');
        exit();
    } else {
        header('Location: ../list/list-otdel?message=err');
        exit();
    }

}
ob_end_flush();
require_once('../template/footer.php');
?>