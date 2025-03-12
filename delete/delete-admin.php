<?php
require_once('../secure.php');
ob_start();
if (!Helper::can('owner')) {
    header('Location: 404');
    exit;
}
$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$admin = (new AdminMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление пользователя</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-owner"><i class="fa
fa-dashboard"></i> Список</a></li>
        <li>Удаление пользователя</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить пользователя:</p>
        <b style="font-size: 18px;">
            <?= $admin->fio; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteowner" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteowner'])) {
    $admin = new AdminMap();
    $admin->deleteadminById($id);
    header('Location: ../list/list-admin?message=ok');
    exit();
}
ob_end_flush();

require_once('../template/footer.php');
?>