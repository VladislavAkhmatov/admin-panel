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
            <input type="hidden" name="archive" value="<?php isset($_GET['archive']) ? $_GET['archive'] : ''; ?>">
            <input class="btn btn-primary" name="deleteTeacher" type="submit" value="Удалить">
        </form>
    </div>
<?php

if (isset($_POST['deleteTeacher'])) {
    if ($_GET['archive'] == 1) {
        if ((new TeacherMap())->deleteArchiveTeacherById($id)) {
            header('Location: ../archive/archive-teacher?message=ok');
            exit();
        }
        header('Location: ../archive/archive-teacher?message=err');
        exit();
    } else {
        (new TeacherMap())->deleteTeacherById($id);
        header('Location: ../list/list-teacher?message=ok');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>