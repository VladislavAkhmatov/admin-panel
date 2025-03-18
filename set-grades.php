<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

require_once 'template/header.php';

?>

    <section class="content-header">
        <h3>
            <b>
                <?= asd ?>
            </b>
        </h3>
        <ol class="breadcrumb">

            <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

            <li>Оценки</li>


        </ol>
    </section>

<?php
require_once 'template/footer.php';
?>