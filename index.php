<?php
require_once 'secure.php';
require_once 'template/header.php';
if (isset($_GET['id'])) {
    $_SESSION['branch'] = (int) $_GET['id'];
}

$id = $_SESSION['branch'];

$userMap = new UserMap();
$indexTeacher = $userMap->teacherCount();
$indexStudent = $userMap->studentCount();
$indexParent = $userMap->parentCount();

$branch = $userMap->findBranchById($id);

$branchWithoutCurrent = (new UserMap())->arrBranchWithoutCurrent();



?>
<script>


</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dashboards/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dashboards/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dashboards/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="dashboards/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="dashboards/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="dashboards/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="dashboards/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">





<body>
    <?php if (Helper::can('manager')) {
        $header = isset($_GET['message']) ? '<span style="color: red;">Неверный формат файла</span>' : $branch->name;
        ?>

        <section class="content-header">
            <h3><b>
                    <?= $header ?>
                </b></h3>
        </section>
        <section class="content-header">
            <h3><b>
                    Дата основания:
                    <?= $branch->date_founding ?>
                </b></h3>
        </section>
        <section class="content">
            <a style="text-decoration: none; color: #333;" href="list/list-teacher">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-stats-bars"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во учителей</b></span>
                            <span class="info-box-number">
                                <?= $indexTeacher->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <a style="text-decoration: none; color: #333;" href="list/list-student">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во учеников</b></span>
                            <span class="info-box-number">
                                <?= $indexStudent->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <a style="text-decoration: none; color: #333;" href="list/list-parent">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во родителей</b></span>
                            <span class="info-box-number">
                                <?= $indexParent->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </section>
    <?php } ?>



    <?php if (Helper::can('admin')) {
        $header = isset($_GET['message']) ? '<span style="color: red;">Неверный формат файла</span>' : $branch->name;
        ?>

        <section class="content-header">
            <h3><b>
                    <?= $header ?>
                </b></h3>
        </section>
        <section class="content-header">
            <h3><b>
                    Дата основания:
                    <?= $branch->date_founding ?>
                </b></h3>
        </section>

        <section class="content-header">
            <h3><b>
                    Список филиалов:

                </b></h3>
        </section>
        <section class="content-header">
            <form id="myForm" action="index" method="GET">
                <?php foreach ($branchWithoutCurrent as $item): ?>
                    <button class="btn btn-primary" type="button" onclick="submitForm(<?= $item->id ?>)">
                        <?= $item->value ?>
                    </button>
                <?php endforeach; ?>
                <input type="hidden" id="selectedId" name="id" value="">
            </form>

            <script>
                function submitForm(id) {
                    document.getElementById('selectedId').value = id;
                    document.getElementById('myForm').submit();

                }
            </script>
        </section>
        <section class="content">
            <a style="text-decoration: none; color: #333;" href="list/list-teacher">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-stats-bars"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во учителей</b></span>
                            <span class="info-box-number">
                                <?= $indexTeacher->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <a style="text-decoration: none; color: #333;" href="list/list-student">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во учеников</b></span>
                            <span class="info-box-number">
                                <?= $indexStudent->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <a style="text-decoration: none; color: #333;" href="list/list-parent">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-person-add"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Кол-во родителей</b></span>
                            <span class="info-box-number">
                                <?= $indexParent->count ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </section>
    <?php } ?>

</html>
</body>

<?php
if (Helper::can('teacher')) {


    $userIdentity = (new UserMap())->identity($_SESSION['id']);
    $user = ((new TeacherMap())->findById($_SESSION['id']));
    if ($userIdentity == UserMap::TEACHER) {
        $schedules = (new ScheduleMap())->findByTeacherId($_SESSION['id']);
    } elseif ($userIdentity == UserMap::STUDENT) {
        $schedules = null;
    }
    require_once 'template/header.php';
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b>
                            Добро пожаловать:
                            <?= $user->fio ?>
                        </b></h3>
                </section>


                <section class="content-header">
                    <h3><b>
                            <a class="btn btn-primary" href="check/check-classes">Журнал</a>
                        </b></h3>
                </section>
                <section class="content-header">
                    <form action="/check/check-replacement">
                        <h3><b>
                                <a class="btn btn-primary" href="check/check-replacement">Замена</a>
                            </b></h3>
                    </form>
                </section>
                <section class="content-header">
                    <h3><b>
                            <?= $header ?>
                        </b></h3>
                </section>
            </div>
        </div>
    </div>
    <?php
}
if (Helper::can('procreator')) {
    require_once 'secure.php';
    if (!Helper::can('procreator')) {
        header('Location: 404');
        exit();
    }
    $size = 10;
    if (isset($_GET['page'])) {
        $page = Helper::clearInt($_GET['page']);

    } else {
        $page = 1;
    }
    $studentMap = new StudentMap();
    $count = $studentMap->count();
    $student = $studentMap->findStudentsFromParent($page * $size - $size, $size);
    $header = isset($_GET['message']) ? '<span style="color: red;">Ошибка</span>' : 'Главная';
    require_once 'template/header.php';
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h1><b>
                            <?= $header ?>
                        </b>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">Главная</li>
                    </ol>
                </section>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php
                    if ($student) {
                        ?>
                        <form action="save/saveStundentInfo" method="POST" enctype="multipart/form-data">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Ф.И.О</th>
                                        <th></th>
                                        <th>Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($student as $student) {
                                        echo '<tr>';
                                        echo '<td><a href="profile/profile-student?id=' . $student->user_id . '">' . $student->fio . '</a> ' . '</td>';
                                        echo '<td><a class="btn btn-primary" href="add/add-reference?id=' . $student->user_id . '">Добавить справку</a> ' . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>

                    <?php } else {
                        echo 'Ни одного студента не найдено';
                    } ?>
                </div>
                <div class="box-body">
                    <?php Helper::paginator($count, $page, $size); ?>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <?php
    require_once 'template/footer.php';
}
require_once 'template/footer.php';


?>