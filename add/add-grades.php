<?php
require_once '../secure.php';

if (!Helper::can('owner') && !Helper::can('admin') && !Helper::can('teacher')) {
    header('Location: 404');
    exit();
}

if (isset($_GET['group'])) {
    $id = Helper::clearInt($_GET['group']);
    $subject_id = $_GET['subject'];
    $schedule_id = $_GET['schedule'];
} else {
    $id = 1;
}

$studentMap = new StudentMap();
$students = $studentMap->findStudentsFromGroup($id);
$subject = (new SubjectMap())->findById($subject_id);
$header = 'Список студентов';
require_once '../template/header.php';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Список студентов</b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Список студентов</li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (Helper::can('owner') || Helper::can('admin')) { ?>
                    <a class="btn btn-success" href="../add/add-student">Добавить студента</a>

                <?php } ?>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($students) { ?>
                    <form action="../save/save-addGrades" method="POST">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ф.И.О</th>
                                    <th>Предмет</th>
                                    <th>Посещаемость</th>
                                    <th>Оценка</th>
                                    <th>Комментарий</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($students as $student) { ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (Helper::can('admin') || Helper::can('teacher')) {
                                                echo '<p>' . $student->fio . '</p> ' . '<a href="../add/add-student.php?id=' . $student->user_id . '"></a>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $subject->name; ?>
                                            <input type="hidden" name="subject_id[<?php echo $student->user_id; ?>]"
                                                value="<?= $subject_id ?>">

                                        </td>
                                        <td>
                                            <input type="hidden" name="attend[<?php echo $student->user_id; ?>]" value="0">
                                            <input type="checkbox" name="attend[<?php echo $student->user_id; ?>]" value="1"
                                                <?php echo ($student->attend == 1) ? 'checked' : ''; ?>>
                                        </td>
                                        <td>
                                            <input type="text" name="grades_id[<?php echo $student->user_id; ?>]">
                                        </td>
                                        <td>
                                            <input type="text" name="comment[<?php echo $student->user_id; ?>]">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <input name="schedule_id" type="hidden" value="<?= $schedule_id ?>">
                        <input name="lesson_plan_id" type="hidden" value="<?= $lesson_plan_id ?>">
                        <input class="btn btn-success" type="submit" name="formSubmit">
                    </form>
                <?php } else {
                    echo 'Ни одного студента не найдено';
                } ?>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hyphenopoly@2.8.0/dist/hyphenopoly.module.js"></script>
<script>
    // Конфигурация переноса слов по слогам для русского языка
    window.hyphenopolyConfig = {
        require: ['ru']
    };
</script>
<script>
    // Функция для обработки изменения состояния чекбокса
    function toggleElements(studentId, isChecked) {
        var inputElements = document.getElementsByName('grades_id[' + studentId + ']');
        var textInput = inputElements[0];
        var commentInput = document.getElementsByName('comment[' + studentId + ']')[0];

        // Если чекбокс активен, делаем элементы видимыми, иначе - скрываем
        if (isChecked) {
            textInput.style.display = 'block';
            commentInput.style.display = 'block';
        } else {
            textInput.style.display = 'none';
            commentInput.style.display = 'none';
        }
    }

    // Находим все чекбоксы и добавляем обработчик для изменения состояния
    var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="attend"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var studentId = this.getAttribute('name').match(/\[(\d+)\]/)[1];
            toggleElements(studentId, this.checked);
        });
    });

    // Вызываем toggleElements для всех чекбоксов, чтобы настройки отображения были актуальными при загрузке страницы
    checkboxes.forEach(function (checkbox) {
        var studentId = checkbox.getAttribute('name').match(/\[(\d+)\]/)[1];
        toggleElements(studentId, checkbox.checked);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/hyphenopoly@2.8.0/dist/configurator.js"></script>
<?php
require_once '../template/footer.php';

?>