<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = Helper::clearInt($_GET['id']);
if ((new TeacherMap())->findById($id)) {
    $teacher = (new UserMap())->findProfileById($id);
} else {
    header('Location: 404');
}
$header = 'План преподавателя: ' . $teacher->fio;
$plans = (new LessonPlanMap())->findByTeacherId($id);
$i = 1;
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b><?= $header; ?></b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>

                    <li><a href="list-teacher-schedule">Расписание</a></li>

                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <div class="box-body">

                <a class="btn btn-success" href="../add/add-plan?id=<?= $id; ?>">Добавить пункт плана</a>

            </div>
            <?php if (Helper::hasFlash()): ?>

                <div class="alert alert-danger alert-dismissible">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                    <h4><i class="icon fa fa-ban"></i>
                        Ошибка!</h4>
                    <?= Helper::getFlash(); ?>
                </div>
            <?php endif; ?>
            <div class="box-body">
                <?php if ($plans): ?>

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Группа</th>
                                <th>Предмет</th>
                                <th>Начало занятия</th>
                                <th>Конец занятия</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($plans as $plan):
                                ?>
                                <tr>
                                    <td>
                                        <?= $i; ?>
                                    </td>

                                    <td><?= $plan->gruppa; ?></td>
                                    <td><?= $plan->subject; ?></td>
                                    <td><?= $plan->time_begin; ?></td>
                                    <td><?= $plan->time_end; ?></td>
                                    <td><a href="../delete/delete-plan?id=<?= $plan->lesson_plan_id; ?>&idplan=<?= $id; ?>"><i
                                                class="fa fa-trash"></i></a></td>

                                </tr>

                                <?php $i++; endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>

                    <p>План отсутствует</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';
?>