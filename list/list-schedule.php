<?php
require_once '../secure.php';
ob_start();
if (!Helper::can('admin') && !Helper::can('manager')) {
    header('Location: 404');
    exit();
}
$id = Helper::clearInt($_GET['id']);
if ((new TeacherMap())->findById($id)->validate()) {
    $teacher = (new UserMap())->findProfileById($id);
} else {
    header('Location: 404');
}
$schedules = (new ScheduleMap())->findByTeacher($id);
$header = 'Расписание преподавателя: ' . $teacher->fio;

require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>

                    <li><a href="list-teacher-schedule">Расписание</a></li>
                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <?php if (isset($_GET['message'])): ?>
                <section class="box-body">
                    <h3>
                        <b>
                            <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : '' ?>
                        </b>
                    </h3>
                </section>
            <?php endif; ?>
            <section class="box-body">
                <h3>
                    <b>
                        <?= $header; ?>
                    </b>
                </h3>
            </section>
            <div class="box-body">
                <form action="../add/add-schedule" method="get">
                    <input class="btn btn-primary" value="Добавить расписание" type="submit">
                    <input name="idUser" type="hidden" value="<?= $teacher->user_id ?>">
                </form>
            </div>
            <?php if ($schedules): ?>
                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>Группа</th>
                            <th>Предмет</th>
                            <th>Время</th>
                            <th>Дата урока</th>
                            <th>Кол-во учеников</th>
                            <th>Кабинет</th>
                            <th>Разрешен</th>
                            <th>Разрешение</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedules as $classes): ?>
                            <tr>
                                <td>
                                    <?= $classes->gruppa; ?>
                                </td>
                                <td>
                                    <?= $classes->subject; ?>
                                </td>
                                <td>
                                    <?= $classes->time; ?>
                                </td>
                                <td>
                                    <?= $classes->date; ?>
                                </td>
                                <td>
                                    <?= $classes->count; ?>
                                </td>
                                <td>
                                    <?= $classes->classroom; ?>
                                </td>
                                <td>
                                    <?php if ($classes->allowed == 1): ?>
                                        <?= 'Да' ?>
                                    <?php else: ?>
                                        <?= 'Нет' ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($classes->allowed == 0): ?>
                                        <form action="list-schedule" method="post">
                                            <input class="btn btn-primary" type="submit" value="Разрешить">
                                            <input type="hidden" name="schedule_id" value="<?= $classes->schedule_id ?>">
                                            <input name="id" type="hidden" value="<?= $teacher->user_id ?>">
                                        </form>
                                    <?php else: ?>
                                        <?= '' ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else:
                echo "Расписания для этого преподавателя отсутствует";
                ?>

            <?php endif; ?>
        </div>
    </div>
</div>
<?php
if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];
    $id = $_POST['id'];
    if ((new ScheduleMap())->allowed($schedule_id)) {
        header("Location: list-schedule?id=$id&message=ok");
        ob_end_flush();
        exit;
    } else {
        header("Location: list-schedule?id=$id&message=err");
        exit;
    }
}
require_once '../template/footer.php';
?>