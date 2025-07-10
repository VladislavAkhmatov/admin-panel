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

$message = 'Отправка квитанций';
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
            <form method="POST" action="/save/save-receipts" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Тип квитанции</label>
                    <select class="form-control" name="type">
                        <option value="1">Чек</option>
                        <option value="2">Возврат</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Примечание</label>
                    <input class="form-control" type="text" name="note">
                </div>
                <div class="form-group">
                    <label>Квитанция</label>
                    <input type="file" name="file">
                </div>
                <div class="form-group">
                    <button name="sendReceipt" type="submit" class="btn btn-primary">Применить</button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once 'template/footer.php';
?>