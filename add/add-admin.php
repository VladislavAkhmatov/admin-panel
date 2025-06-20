<?php
require_once '../secure.php';
if (!Helper::can('owner')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$admin = (new AdminMap())->findById($id);
$header = (($id) ? 'Редактировать данные' : 'Добавить') . '
администратора';
if (isset($_GET['q'])) {
    $header = 'Ошибка при добавлении пользователя <br> (Возможно такой логин уже используется)';
}
require_once '../template/header.php';
?>
    <section class="content-header">
        <h3>
            <b>
                <?php echo isset($_GET['q']) ? "<p style='color: red'> $header <p>" : $header ?>
            </b>
        </h3>
        <ol class="breadcrumb">

            <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

            <li><a href="../list/list-admin">Администраторы</a></li>

            <li class="active">
                <?= $header; ?>
            </li>
        </ol>
    </section>
    <div class="box-body">
        <form action="../save/save-user" method="POST">
            <?php require_once '../_formUser.php'; ?>
            <div class="form-group">
                <label>Пол</label>
                <select class="form-control" name="gender_id">
                    <?= Helper::printSelectOptions(
                        $user->gender_id,
                        $userMap->arrGenders()
                    ); ?>
                </select>
            </div>
        </form>
    </div>
<?php
require_once '../template/footer.php';
?>