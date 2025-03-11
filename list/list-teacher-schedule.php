<?php
$header = 'Расписание и планы преподавателей';
require_once '../secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
require_once '../template/header.php';
$size = 5;
if (isset($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);
} else {
    $page = 1;
}
$count = (new TeacherMap())->count();
$teachers = (new LessonPlanMap())->findTeachers($page * $size - $size, $size);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b>
                        <?= $header; ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fafa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <?php if ($teachers): ?>
                <div class="box-body">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Ф.И.О. преподавателя</th>
                                <th>Предмет</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td>
                                        <?= $teacher->fio; ?>
                                    </td>

                                    <td>
                                        <?= $teacher->count_plan; ?>
                                    </td>

                                    <td>

                                        <a href="list-plan?id=<?= $teacher->user_id; ?>" title="План

преподавателя"><i class="fa fa-table"></i></a>&nbsp;

                                        <a href="list-schedule?id=<?= $teacher->user_id; ?>" title="Расписание преподавателя"><i
                                                class="fa fa-calendar-plus-o"></i></a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <div class="box-body">
                    <?php Helper::paginator($count, $page, $size); ?>
                </div>
            <?php else: ?>
                <div class="box-body">
                    <p>Преподаватели не найдены</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>