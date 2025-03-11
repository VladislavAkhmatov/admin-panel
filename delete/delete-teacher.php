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
$teacher = (new TeacherMap())->findById($id);
require_once('../template/header.php');

?>
<section class="content-header">
    <h3><b>Удаление пользователя</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-teacher"><i class="fa fa-dashboard"></i> Список учителей</a></li>
        <li><a href="../list/list-student">Удаление пользователя</a></li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить пользователя:</p>
        <b style="font-size: 18px;">
            <?= $teacher->fio; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteTeacher" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteTeacher'])) {

    (new TeacherMap())->deleteTeacherById($id);
    header('Location: ../list/list-teacher?message=ok');
    exit();

}
ob_end_flush();
require_once('../template/footer.php');
?>