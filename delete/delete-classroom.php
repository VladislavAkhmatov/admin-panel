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
$classroom = (new ClassroomMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление кабинета</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-gruppa"><i class="fa
fa-dashboard"></i> Список кабинетов</a></li>
        <li>Удаление кабинетов</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить кабинет:</p>
        <b style="font-size: 18px;">
            <?= $classroom->name; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteClassroom" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteClassroom'])) {
    if ((new ClassroomMap())->deleteClassroomById($id)) {
        header('Location: ../list/list-classroom?message=ok');
        exit();
    } else {
        header('Location: ../list/list-classroom?message=err');
        exit();
    }


}
ob_end_flush();
require_once('../template/footer.php');
?>