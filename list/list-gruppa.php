<?php
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager') && !Helper::can('teacher')) {
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
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список групп' ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (!Helper::can('teacher')): ?>
                    <a class="btn btn-success" href="../add/add-gruppa">Добавить группу</a>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <?php
                if ($gruppas) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Дата образования</th>
                                <th>Дата окончания</th>
                                <?php if (Helper::can('manager')) { ?>
                                    <th>Филиал</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($gruppas as $gruppa) {
                                echo '<tr>';
                                if (!Helper::can('teacher')):
                                    echo '<td><a href="../view/view-gruppa?id=' . $gruppa->gruppa_id . '">' . $gruppa->name . '</a> ' . '<a href="../add/add-gruppa?id=' . $gruppa->gruppa_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-gruppa?id=' . $gruppa->gruppa_id . '"><i class="fa fa-times"></i></a></td>';
                                else:
                                    echo '<td><p href="../view/view-gruppa?id=' . $gruppa->gruppa_id . '">' . $gruppa->name . '</p> ' . '</td>';
                                endif;
                                echo '<td>' . date(
                                    "d.m.Y",
                                    strtotime($gruppa->date_begin)
                                ) . '</td>';
                                echo '<td>' . date(
                                    "d.m.Y",
                                    strtotime($gruppa->date_end)
                                ) . '</td>';
                                if (Helper::can('manager')) {
                                    echo '<td>' . $gruppa->branch . '</td>';
                                    echo '</tr>';
                                }

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