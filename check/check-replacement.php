<?php
require_once '../secure.php';
require_once '../template/header.php';
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $id = $_GET['id'];
    $schedules = (new ScheduleMap())->findByDayTeacher($id, $date);
}
$header = 'Расписание занятий.';

if (isset($_GET['date']) && isset($_GET['id'])) {
    $replaceable = (new TeacherMap())->findById($_GET['id']);
    $replacing = (new TeacherMap())->findById($_SESSION['id']);
    $header = 'Расписание занятий. ' . $replaceable->fio;
    $temp = 'Заменяющий: ' . $replacing->fio;
}
?>

<?php if (isset($_GET['message'])): ?>
    <section class="content-header">
        <h3><b>
                <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : '' ?>
            </b></h3>
    </section><br>
<?php endif; ?>

<?php if (isset($_GET['date'])): ?>
    <section class="content-header">
        <h3><b>
                <?= $header ?>
            </b></h3>
    </section>
    <?php if (isset($_GET['date']) && isset($_GET['id'])): ?>
        <section class="content-header">
            <h3><b>
                    <?= $temp ?>
                </b></h3>
        </section>
    <?php endif; ?>
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
        <?php if (empty($_GET['id'])): ?>
            <form action="check-replacement" method="get">
                <label>Заменяю</label>
                <select style="width: 300px;" class="form-control" name="id">
                    <?= Helper::printSelectOptions(0, (new TeacherMap())->arrTeachers()) ?>
                </select><br>
                <input class="btn btn-primary" type="submit" value="Далее">
            </form>
        <?php endif; ?>
        <?php if (isset($_GET['id'])): ?>
            <form action="check-replacement" method="get">
                <label>Выберите дату</label>
                <select style="width: 300px;" class="form-control" name="date">
                    <?= Helper::printSelectOptionsDate((new ScheduleMap())->arrDate()) ?>
                </select>
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <br>
                <input class="btn btn-primary" type="submit" value="Узнать расписание">
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php
require_once '../template/footer.php';
?>