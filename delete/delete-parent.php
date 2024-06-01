<?php
require_once('../secure.php');
ob_start();
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit;
}

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$parent = (new ProcreatorMap())->findById($id);
require_once('../template/header.php');

?>
<section class="content-header">
    <h3><b>Удаление пользователя</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-parent"><i class="fa
fa-dashboard"></i> Список родителей</a></li>
        <li><a href="../list/list-student">Удаление пользователя</a></li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить пользователя:</p>
        <b style="font-size: 18px;">
            <?= $parent->fio; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteParent" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteParent'])) {
    $procreator = new ProcreatorMap();
    if ($procreator->deleteParentById($id)) {
        header('Location: ../list/list-parent?message=ok');
        exit();
    } else {
        header('Location: ../list/list-parent?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>