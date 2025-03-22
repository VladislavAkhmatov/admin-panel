<?php
require_once 'secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$student = new StudentMap();
$subject = new SubjectMap();
$group = new GruppaMap();

$allStudents = null;
$getSubject = null;
$getGroup = null;

$group_id = 0;
$subject_id = 0;

if ($_GET['group_id'] && $_GET['subject_id']) {
    $group_id = $_GET['group_id'];
    $subject_id = $_GET['subject_id'];

    $getGroup = $group->findById($group_id);
    $allStudents = $student->findByGruppaID($group_id);
    $getSubject = $subject->findById($subject_id);
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
            <label for="groupSelect">Группа: <?= $getGroup->name ?></label>
            <br>
            <label for="subjectSelect">Предмет: <?= $getSubject->name ?></label>
            <br>
        </div>
    </div>
    <div class="container mt-5">
<?php if ($allStudents): ?>
    <form action="save/save-balance" method="post">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Кол-во уроков</th>
                <th scope="col">Добавить уроки</th>
                <th scope="col">Списать уроки</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allStudents as $item): ?>
                <?php
                $balance = (new BalanceMap())->findByUserIdAndSubjectId($item->user_id, $subject_id);
                ?>
                <tr>
                    <td>
                        <p class="pt-3"><?= $item->user ?></p>
                    </td>
                    <td>
                        <p><?= $balance->count ?></p>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="addCounts[<?= $item->user_id ?>]"
                               min="0">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="reduceCounts[<?= $item->user_id ?>]"
                               min="0">
                    </td>
                    <input type="hidden" name="user_ids[]" value="<?= $item->user_id ?>">
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <input type="hidden" value="<?= $subject_id ?>" name="subject_id">
        <input class="btn btn-primary" type="submit" value="Сохранить">
    </form>
    </div>
<?php else: ?>
    <p>Ни одной записи не найдено</p>
<?php endif; ?>
<?php
require_once 'template/footer.php';
?>