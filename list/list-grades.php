<?php
require_once '../secure.php';
if (!Helper::can('manager') && !Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
$size = 5;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$gruppaMap = new GruppaMap();
$count = $gruppaMap->count();
$gruppas = $gruppaMap->findAll($page * $size - $size, $size);
$header = 'Список групп';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b>
                        <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список оценок'; ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        Список групп
                    </li>
                </ol>
            </section>
            <div class="box-body">
                <?php
                if ($gruppas) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Просмотр</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($gruppas as $gruppa) {
                                echo '<tr>';
                                if (Helper::can('teacher') || Helper::can('manager'))
                                    echo '<td><p href="../view/view-grades?id=' . $gruppa->gruppa_id . '">' . $gruppa->name . '</p> ' . '<p href="../add/add-gruppa?id=' . $gruppa->gruppa_id . '"></p></td>';
                                echo '<td><a class="btn btn-primary" href="../add/add-grades?id=' . $gruppa->gruppa_id . '">Выставить оценки</a> ' . '<p href="../add/add-gruppa?id=' . $gruppa->gruppa_id . '"></p></td>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одной группы не найдено';
                } ?>
            </div>
            <div class="box-body">
                <?php Helper::paginator(
                    $count,
                    $page,
                    $size
                ); ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>