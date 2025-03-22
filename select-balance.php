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

}

$message = 'Просмотреть баланс уроков';
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

            <li>Баланс оценок</li>


        </ol>
    </section>
    <div class="box-body">
        <div class="form-group">
            <form method="GET" action="set-balance">
                <div class="form-group">
                    <label>Предмет</label>
                    <select class="form-control" name="subject_id">
                        <?php Helper::printSelectOptions(0, (new SubjectMap)->arrSubjects()) ?>
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
<?php
require_once 'template/footer.php';
?>