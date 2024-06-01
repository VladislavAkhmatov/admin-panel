<?php
require_once 'secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$procreatorMap = new ProcreatorMap();
$procreator = $procreatorMap->findHomeworkById($id);
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
                <?php if (Helper::can('admin')) { ?>
                    <a class="btn btn-success" href="add-otdel">Добавить отдел</a>
                <?php }
                ; ?>
            </div>
            <div class="box-body">
                <?php
                if ($procreator) {
                    ?>
                    <table id="example2" class="table table-bordered table-hover">
                        <tbody>
                            <?php
                            echo '<tr>';
                            echo '<th>Название задания:</th>';
                            echo '<td>' . $procreator->name . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Преподаватель:</th>';
                            echo '<td>' . $procreator->fio . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<tr>';
                            echo '<th>Группа:</th>';
                            echo '<td>' . $procreator->gruppa . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Начать выполнение с:</th>';
                            echo '<td>' . $procreator->date_begin . '</td>';
                            echo '</tr>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Закончить до:</th>';
                            echo '<td>' . $procreator->date_end . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Предмет:</th>';
                            echo '<td>' . $procreator->subject . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Файл с заданием:</th>';
                            echo '<td>' . '<a href="homework-teacher/' . $procreator->file . '">' . preg_replace("/^[0-9_]+/", "", $procreator->file) . '</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Загрузить файл с выполненым заданием:</th>';
                            echo "<td>" . '<form action="save/save-homework-parent" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="homework_teacher_id" value="' . $procreator->id . '">
                                        <input type="hidden" name="name" value="' . $procreator->name . '">
                                        <input type="hidden" name="teacher_id" value="' . $procreator->user_id . '">
                                        <input type="hidden" name="gruppa_id" value="' . $procreator->gruppa_id . '">
                                        <input type="hidden" name="student_id" value="' . $_SESSION['child_id'] . '">
                                        <input type="hidden" name="date_begin" value="' . $procreator->date_begin . '">
                                        <input type="hidden" name="date_end" value="' . $procreator->date_end . '">
                                        <input type="hidden" name="subject_id" value="' . $procreator->subject_id . '">
                                        <input type="hidden" name="file" value="' . $procreator->file . '">
                                        <input type="file" name="file_prepared">
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