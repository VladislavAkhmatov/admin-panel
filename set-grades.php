<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
$schedule = new ScheduleMap();
$student = new StudentMap();

$foundSchedule = null;
$allStudents = null;

if ($_GET['schedule'] && $_GET['group']) {
    $schedule_id = $_GET['schedule'];
    $group_id = $_GET['group'];

    $foundSchedule = $schedule->findScheduleByID($schedule_id);
    $allStudents = $student->findByGruppaID($group_id);
}

require_once 'template/header.php';

?>

    <section class="content-header">
        <h3>
            <b>
                <?= 'Выставить оценки' ?>
            </b>
        </h3>
        <ol class="breadcrumb">

            <li><a href="/index"><i class="fa fa-dashboard"></i> Главная</a></li>
            <li><a href="/select-schedule">Оценки</a></li>

            <li>Выставить оценок</li>


        </ol>
    </section>
    <div class="box-body">
        <div class="form-group">
            <label for="groupSelect">Группа: <?= $foundSchedule->gruppa ?></label>
            <br>
            <label for="subjectSelect">Предмет: <?= $foundSchedule->subject ?></label>
            <br>
            <label for="teacherSelect">Преподаватель: <?= $foundSchedule->user ?></label>
            <br>
            <label for="monthSelect">
                Дата: <?= Helper::formattedData($foundSchedule->date) ?></label>
            <br>
        </div>
    </div>
    <div class="container mt-5">
<?php if ($allStudents): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Имя</th>
            <th scope="col">Присутствовал</th>
            <th scope="col">Активность</th>
            <th scope="col">Домашняя работа</th>
        </tr>
        </thead>
        <tbody>
        <form action="save/save-grades" method="post">
            <?php foreach ($allStudents as $item): ?>
                <tr>
                    <td>
                        <p class="pt-3"><?= $item->user ?></p>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="attends[]" value="1">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="activities[]" placeholder="Введите текст">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="homeworks[]" placeholder="Введите текст">
                    </td>
                    <input type="hidden" name="user_ids[]" value="<?= $item->user_id ?>">
                </tr>
            <?php endforeach; ?>
            <input class="btn btn-primary" type="hidden" name="schedule_id" value="<?= $foundSchedule->schedule_id ?>">
            <input class="btn btn-primary" type="submit" value="Сохранить">
        </form>
        </tbody>
    </table>
    </div>
<?php else: ?>
    <p>Ни одной записи не найдено</p>
<?php endif; ?>
<?php
require_once 'template/footer.php';
?>