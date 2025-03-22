<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$schedule = new ScheduleMap();
$allSchedule = null;
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $subject_id = $_GET['subject_id'];
    $teacher_id = $_GET['teacher_id'];
    $group_id = $_GET['group_id'];
    $allSchedule = $schedule->findByParams($date, $teacher_id, $subject_id, $group_id);
}

$message = 'Просмотреть оценки';

require_once 'template/header.php';

?>
    <section class="content-header">
        <h3>
            <b>
                <?= $message; ?>
            </b>
        </h3>
        <ol class="breadcrumb">

            <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>

            <li>Оценки</li>


        </ol>
    </section>
    <div class="box-body">
        <div class="form-group">
            <form method="GET" action="select-schedule">
                <div class="form-group">
                    <label>Дата</label>
                    <input class="form-control" type="date" name="date" required>
                </div>
                <div class="form-group">
                    <label>Предмет</label>
                    <select class="form-control" name="subject_id">
                        <?php Helper::printSelectOptions(0, (new SubjectMap)->arrSubjects()) ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Учитель</label>
                    <select class="form-control" name="teacher_id">
                        <?php Helper::printSelectOptions(0, (new TeacherMap())->arrTeachers()) ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Группа</label>
                    <select class="form-control" name="group_id">
                        <?php Helper::printSelectOptions(0, (new GruppaMap)->arrGruppas()) ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
            </form>
        </div>
    </div>
<?php if ($allSchedule != null): ?>
    <div class="box-body" style="display: flex;">
        <?php foreach ($allSchedule as $item): ?>
            <form action="set-grades" method="get">
                <input class="btn btn-primary" style="margin-right: 5px" type="submit" value="<?= $item->time ?>">
                <input type="hidden" name="schedule" value="<?= $item->schedule_id ?>">
                <input type="hidden" name="group" value="<?= $item->group_id ?>">
            </form>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="box-body">
        Ни одной записи не найдено
    </div>
<?php endif; ?>
<?php
require_once 'template/footer.php';
?>