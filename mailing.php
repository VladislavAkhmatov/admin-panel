<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin') && !Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
$schedule = new ScheduleMap();
$allSchedule = null;
if (isset($_GET['subject_id'])) {
    $_SESSION['role'] == 'teacher' ? date('Y-m-d') : $date = $_GET['date'];
    $subject_id = $_GET['subject_id'];
    $_SESSION['role'] == 'teacher' ? $teacher_id = $_SESSION['id'] : $teacher_id = $_GET['teacher_id'];
    $group_id = $_GET['group_id'];
    $allSchedule = $schedule->findByParams($date, $subject_id, $group_id);
}

$message = 'Создать рассылку';
if (isset($_GET['q'])) {
    $message = Helper::message($_GET['q']);
}
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

            <li><?= $message; ?></li>
        </ol>
    </section>
    <div class="box-body">
        <div class="form-group">
            <form method="POST" action="/save/save-mailing">
                <div class="form-group">
                    <label>Текст рассылки</label><br>
                    <textarea class="form-control" name="message"></textarea>
                </div>
                <div class="form-group">
                    <label>Срок действия рассылки</label><br>
                    <input type="datetime-local" class="form-control" name="end_period">
                </div>
                <div class="form-group">
                    <button name="mailing" type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once 'template/footer.php';
?>