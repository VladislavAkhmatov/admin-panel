<?php
require_once 'secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$userMap = new UserMap();

require_once 'template/header.php';

?>
<section class="content-header">
    <h3>
        <b>
            <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Создать оплату'; ?>
        </b>
    </h3>
    <ol class="breadcrumb">
        <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li>Создать оплату</li>
    </ol>
</section>
<div class="box-body">
    <div class="form-group">
        <form method="GET" action="../add/add-notice">
            <div class="form-group">
                <label>Кому</label>
                <select class="form-control" name="id">
                    <?php Helper::printSelectOptions(0, $userMap->ArrParents()) ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Далее</button>
            </div>
        </form>
    </div>
</div>
<?php

require_once 'template/footer.php';
?>