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
$subject = (new SubjectMap())->findById($id);
require_once('../template/header.php');
?>
<section class="content-header">
    <h3><b>Удаление предмета</b></h3>
    <ol class="breadcrumb">
        <li><a href="../list/list-subject"><i class="fa
fa-dashboard"></i> Список предметов</a></li>
        <li>Удаление предметов</li>
    </ol>
</section>

<div class="box-body">
    <form method="POST">
        <p style="font-size: 16px;">Вы действительно хотите удалить предмет:</p>
        <b style="font-size: 18px;">
            <?= $subject->name; ?>
        </b><br><br>
        <input class="btn btn-primary" name="deleteSubject" type="submit" value="Удалить">
    </form>
</div>
<?php

if (isset($_POST['deleteSubject'])) {
    if ((new SubjectMap())->deleteSubjectById($id)) {
        header('Location: ../list/list-subject?message=ok');
        exit();
    } else {
        header('Location: ../list/list-subject?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>