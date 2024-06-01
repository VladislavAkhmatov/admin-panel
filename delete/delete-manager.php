<?php
require_once('../secure.php');
ob_start();
if (!Helper::can('admin')) {
    header('Location: 404');
    exit;
}
$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$manager = (new ManagerMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление пользователя</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-admin"><i class="fa
fa-dashboard"></i> Список</a></li>
        <li>Удаление пользователя</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить пользователя:</p>
        <b style="font-size: 18px;">
            <?= $manager->fio; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteAdmin" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteAdmin'])) {
    $manager = new ManagerMap();
    $manager->deleteManagerById($id);
    header('Location: ../list/list-manager?message=ok');
    exit();
}
ob_end_flush();

require_once('../template/footer.php');
?>