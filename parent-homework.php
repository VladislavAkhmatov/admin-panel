<?php
require_once 'secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$teacher = (new TeacherMap())->findHomeworkById($id);


$header = 'Домашнее задание';
require_once 'template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3>
                    <b>
                        <?= $header; ?>
                    </b>
                </h3>
                <ol class="breadcrumb">
                    <li><a href="/index"><i class="fafa-dashboard"></i> Главная</a></li>
                    <li class="active">
                        <?= $header; ?>
                    </li>
                </ol>
            </section>
            <div class="box-body">
                <?php if (Helper::can('owner')) { ?>
                    <a class="btn btn-success" href="add-otdel">Добавить отдел</a>
                <?php }
                ; ?>
            </div>
            <div class="box-body">
                <?php
                if ($teacher) {
                    ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <tbody>
                            <?php
                            echo '<tr>';
                            echo '<th>Название задания:</th>';
                            echo '<td>' . $teacher->name . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Отправил(а):</th>';
                            echo '<td>' . $teacher->student_fio . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<tr>';
                            echo '<th>Группа:</th>';
                            echo '<td>' . $teacher->gruppa . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Начать выполнение с:</th>';
                            echo '<td>' . $teacher->date_begin . '</td>';
                            echo '</tr>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Закончить до:</th>';
                            echo '<td>' . $teacher->date_end . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Предмет:</th>';
                            echo '<td>' . $teacher->subject . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Файл с заданием:</th>';
                            echo '<td>' . '<a href="homework-teacher/' . $teacher->file . '">' . preg_replace("/^[0-9_]+/", "", $teacher->file) . '</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Файл с выполненным заданием:</th>';
                            echo '<td>' . '<a href="homework-student/' . $teacher->file_prepared . '">' . preg_replace("/^[0-9_]+/", "", $teacher->file_prepared) . '</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Оценка за задание:</th>';
                            echo "<td>" . '<form action="save/save-grades-from-homework" method="post">
                                        <input type="hidden" name="id" value="' . $teacher->id . '">
                                        <input type="hidden" name="user_id" value="' . $teacher->student_id . '">
                                        <input type="hidden" name="subject_id" value="' . $teacher->subject_id . '">
                                        <input type="hidden" name="homework" value="' . $teacher->file_prepared . '">
                                        <input type="text" name="grades">
                                        ' . "</td>";
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Комментарий:</th>';
                            echo "<td>" . '<form action="save/save-grades-from-homework" method="post">
                            <input type="text" name="comment">
                            ' . "</td>";
                            echo '</tr>';
                            echo '<tr>';
                            ?>
                            <td> <button class="btn btn-success" type="submit" name="saveHomeworkStudent">Сохранить</button>
                            </td>
                            <?php
                            echo '</tr>';
                            echo '</form>';
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Домашнее задание не найдено';
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'template/footer.php';
?>