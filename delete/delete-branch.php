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
$branch = (new BranchMap())->findById($id);
require_once('../template/header.php');
?>
    <section class="content-header">
        <h3><b>Удаление филиала</b></h3>
        <ol class="breadcrumb">
            <li><a href="../list/list-branch"><i class="fa
fa-dashboard"></i> Список филиалов</a></li>
            <li>Удаление филиала</li>
        </ol>
    </section>

    <div class="box-body">
        <form method="POST">
            <p style="font-size: 16px;">Вы действительно хотите удалить филиал?</p>
            <b style="font-size: 18px;">
                <?= $branch->branch; ?>
            </b><br><br>
            <input class="btn btn-primary" name="deleteBranch" type="submit" value="Удалить">
        </form>
    </div>
<?php
if (isset($_POST['deleteBranch'])) {
    if ((new BranchMap())->delete($id)) {
        header('Location: ../list/list-branch?message=ok');
        exit();
    } else {
        header('Location: ../list/list-branch?message=err');
        exit();
    }
}
ob_end_flush();
require_once('../template/footer.php');
?>