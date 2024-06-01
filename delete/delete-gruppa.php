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
$gruppa = (new GruppaMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление группы</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-gruppa"><i class="fa
fa-dashboard"></i> Список групп</a></li>
        <li>Удаление группы</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить группу:</p>
        <b style="font-size: 18px;">
            <?= $gruppa->name; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteGruppa" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteGruppa'])) {
    if ((new GruppaMap())->deleteGruppaById($id)) {
        header('Location: ../list/list-gruppa?message=ok');
        exit();
    } else {
        header('Location: ../list/list-gruppa?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>