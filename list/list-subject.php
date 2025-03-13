<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$size = 5;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$subjectMap = new SubjectMap();
$count = $subjectMap->count();
$subjects = $subjectMap->findAll($page * $size - $size, $size);

require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b>
                        <?= $header = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Список предметов' ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        Список
                        предметов
                    </li>
                </ol>
            </section>
            <div class="box-body">
                <a class="btn btn-success" href="../add/add-subject">Добавить предмет</a>
            </div>
            <div class="box-body">
                <?php
                if ($subjects) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Название</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($subjects as $subject) {
                                echo '<tr>';
                                echo '<td><a href="../view/view-subject?id=' . $subject->subject_id . '">' . $subject->name . '</a> '
                                    . '<a href="../add/add-subject?id=' . $subject->subject_id . '"><i class="fa fa-pencil"></i></a>  <a href="../delete/delete-subject?id=' . $subject->subject_id . '"><i class="fa fa-times"></i></a></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного предмета не найдено';
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