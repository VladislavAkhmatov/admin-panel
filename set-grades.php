<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
$schedule = new ScheduleMap();
$group = new GruppaMap();

$foundSchedule = null;
$foundGroup = null;
if ($_GET['schedule']) {
    $schedule_id = $_GET['schedule'];
    $foundSchedule = $schedule->findScheduleByID($schedule_id);

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
            <tr>
                <td>
                    <p class="pt-3">asdaasd</p>
                </td>
                <td>
                    <input class="form-check-input" type="checkbox" value="" id="checkbox2">
                </td>
                <td>
                    <input type="number" class="form-control" id="input3" placeholder="Введите текст">
                </td>
                <td>
                    <input type="number" class="form-control" id="input4" placeholder="Введите текст">
                </td>

            </tr>
            </tbody>
        </table>
    </div>
<?php
require_once 'template/footer.php';
?>