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
$student = (new StudentMap())->findById($id);
require_once('../template/header.php');

?>
<section class="content-header">
    <h3><b>Удаление пользователя</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-parent"><i class="fa
fa-dashboard"></i> Список</a></li>
        <li><a href="../list/list-student">Удаление пользователя</a></li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить пользователя:</p>
        <b style="font-size: 18px;">
            <?= $student->fio; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteStudent" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteStudent'])) {
    $student = new StudentMap();
    if ($student->deleteStudentById($id)) {
        header('Location: ../list/list-student?message=ok');
        exit();
    } else {
        header('Location: ../list/list-student?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>