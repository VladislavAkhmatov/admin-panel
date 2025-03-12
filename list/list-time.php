<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
        header('Location: 404');
        exit();
}
$size = 5;
if (isset ($_GET['page'])) {
        $page = Helper::clearInt($_GET['page']);
} else {
        $page = 1;
}
$specialMap = new SpecialMap();
$count = $specialMap->count();
$specials = $specialMap->findAll($page * $size - $size, $size);
$header = 'Список времени';
require_once '../template/header.php';
?>
<div class="row">
        <div class="col-xs-12">
                <div class="box">
                        <section class="content-header">
                                <h3>
                                        <b>
                                        <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : $header ?>
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
                                <?php if (Helper::can('owner') || Helper::can('admin')) { ?>
                                        <a class="btn btn-success" href="../add/add-time">Добавить время</a>
                                <?php }
                                ; ?>
                        </div>
                        <div class="box-body">
                                <?php
                                if ($specials) {
                                        ?>

                                        <table id="example2" class="table table-bordered table-hover">

                                                <thead>
                                                        <tr>
                                                                <th>Предмет</th>
                                                                <th>Начало занятия</th>
                                                                <th>Конец занятия</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                        foreach ($specials as $special) {
                                                                echo '<tr>';
                                                                echo '<td><a href="../view/view-time?id=' . $special->special_id . '">' . $special->subject . '</a> '
                                                                        . '<a href="../add/add-time?id=' . $special->special_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-time?id=' . $special->special_id . '"><i class="fa fa-times"></i></a></td>';
                                                                echo '<td>' . $special->time_begin . '</td>';
                                                                echo '<td>' . $special->time_end . '</td>';

                                                                echo '</tr>';
                                                        }
                                                        ?>
                                                </tbody>
                                        </table>
                                <?php } else {
                                        echo 'Ни одной записи не найдено';
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