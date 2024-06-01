<?php

require_once "../secure.php";

if (!Helper::can("admin")) {
    header('Location: 404');
    exit;
}
$branchWithoutCurrent = (new UserMap())->arrBranchWithoutCurrent();

require_once '../template/header.php';
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
        <li class="active">Список
            администраторов</li>
    </ol>
</section>
<section class="content-header">
    <h3><b>
            <?= $header = isset ($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список филиалов' ?>
        </b></h3>
</section>
<section class="content-header">
    <form id="myForm" action="../index" method="GET">
        <?php foreach ($branchWithoutCurrent as $item): ?>
            <button class="btn btn-primary" type="button" onclick="submitForm(<?= $item->id ?>)">
                <?= $item->value ?>
            </button>
        <?php endforeach; ?>
        <input type="hidden" id="selectedId" name="id" value="">
    </form>

    <script>
        function submitForm(id) {
            document.getElementById('selectedId').value = id;
            document.getElementById('myForm').submit();

        }
    </script>

</section>
<section class="content-header">
    <a class="btn btn-success" href="../add/add-branch"> Добавить филиал</a>
</section>
<?php
require_once "../template/footer.php";
?>