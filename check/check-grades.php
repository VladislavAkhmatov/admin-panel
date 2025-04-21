<?php
require_once '../secure.php';

$student_id = 0;
$id = 0;
$subject_id = 0;

if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
    if(isset($_GET['subject_id'])) {
        $subject_id = Helper::clearInt($_GET['subject_id']);
    }
} else {
    header('Location: 404');
}

$studentMap = new StudentMap();
$student = $studentMap->findStudentById($id);

$gradeMap = new GradeMap();
$student_id = $student->user_id;
$grades = $gradeMap->findByUserAndSubject($student_id, $subject_id);

$subjectMap = new SubjectMap();

$header = 'Список студентов';

require_once '../template/header.php';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header m-5">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::message($_GET['message']) : $student->fio; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active"><?= $student->fio ?></li>
                    <li class="active">Оценки</li>
                </ol>
            </section>
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <form action="check-grades">
                    <select class="form-control" name="subject_id">
                        <?= Helper::printSelectOptions($subject_id, $subjectMap->arrSubjects()) ?>
                    </select>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button class="btn btn-primary" style="margin-top: 20px;" type="submit">Посмотреть оценки</button>
                </form>
            </div>
            <?php if ($grades): ?>
                <div class="container mt-4">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Посещаемость</th>
                            <th>Активность</th>
                            <th>Дом. работа</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td><?= Helper::formattedData($grade->date) ?></td>
                                <td><?= Helper::attend($grade->attend) ?></td>
                                <td><?= $grade->activity ?></td>
                                <td><?= $grade->homework ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="container">
                    <p>Ни одной оценки не найдено</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
