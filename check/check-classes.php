<?php
require_once '../secure.php';
require_once '../template/header.php';
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $schedules = (new ScheduleMap())->findByDayTeacher($_SESSION['id'], $date);
}
$header = 'Расписание занятий.';

?>

<?php if (isset($_GET['message'])): ?>
    <section class="content-header">
        <h3><b>
                <?= $message = isset($_GET['message']) ? Helper::message($_GET['message']) : '' ?>
            </b></h3>
    </section><br>
<?php endif; ?>

<?php if (isset($_GET['date'])): ?>
    <section class="content-header">
        <h3><b>
                <?= $header ?>
            </b></h3>
    </section>
    <div class="box-body">


        <?php if (empty($schedules)): ?>
            <tr>
                <td colspan="3">Отсутствует расписание на этот день</td>
            </tr>
        <?php endif; ?>
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
                        <th></th>
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
                                <form action="../add/add-grades" method="get">
                                    <input class="btn btn-primary" type="submit" value="Выставить оценки">
                                    <input type="hidden" name="group" value="<?= $classes->gruppa_id ?>">
                                    <input type="hidden" name="schedule" value="<?= $classes->schedule_id ?>">
                                    <input type="hidden" name="subject" value="<?= $classes->subject_id ?>">
                                    <input type="hidden" name="lesson_plan" value="<?= $classes->lesson_plan_id ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php else: ?>
        </table>
        <form action="check-classes" method="get">
            <label>Выберите дату</label>
            <select style="width: 300px;" class="form-control" name="date">
                <?= Helper::printSelectOptionsDate((new ScheduleMap())->arrDate()) ?>
            </select><br>
            <input class="btn btn-primary" type="submit" value="Узнать расписание">
        </form>
    </div>
<?php endif; ?>
<?php
require_once '../template/footer.php';
?>