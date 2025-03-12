<?php
require_once '../secure.php';

if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
$size = 10;

$user_id = 0;
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}

$subject_id = 0;
if (isset($_POST['subject_id'])) {
    $subject_id = $_POST['subject_id'];
}

$branch_id = 0;
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}

$gradesInfo = (new ProcreatorMap())->findPerformanceBygradesInfo($user_id, $subject_id, $branch_id);
$header = 'Студент';
require_once '../template/header.php';

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>Успеваемость</b></h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> Главная</li>
                </ol>
            </section>
            <div class="box-body">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($gradesInfo) { ?>
                    <form method="POST">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    // Генерация заголовков по датам
                                    foreach ($gradesInfo as $item) {
                                        echo '<th>' . $item->date . '</th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Генерация строк по категориям
                                $categories = ["Присутствовал", "Домашнее задание", "Активность", "Комментарий"];
                                foreach ($categories as $category) {
                                    echo "<tr>";
                                    echo "<td><b>$category</b></td>";

                                    // Генерация ячеек для каждой даты
                                    foreach ($gradesInfo as $item) {
                                        // В зависимости от категории выводим соответствующее значение
                                        switch ($category) {
                                            case "Присутствовал":
                                                if ($item->attend == 1) {
                                                    echo "<td>Б</td>";
                                                } else if ($item->attend == 0) {
                                                    echo "<td>Н</td>";
                                                }
                                                break;
                                            case "Домашнее задание":
                                                if ($item->homework != NULL) {
                                                    echo "<td><a href='../homework-student/$item->homework'>" . preg_replace("/^[0-9_]+/", "", $item->homework) . "</a></td>";
                                                } else {
                                                    echo "<td>-</td>";

                                                }
                                                break;
                                            case "Активность":
                                                if ($item->grades != 0) {
                                                    echo "<td>$item->grades</td>";
                                                } else {
                                                    echo "<td>-</td>";
                                                }
                                                break;
                                            case "Комментарий":
                                                if ($item->comment != NULL) {
                                                    echo "<td>$item->comment</td>";
                                                } else {
                                                    echo "<td>-</td>";
                                                }
                                                break;
                                            default:
                                                echo "<td></td>"; // Для остальных случаев
                                        }
                                    }

                                    echo "</tr>";

                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                <?php } else {
                    echo 'Ни одной записи не найдено';
                } ?>
            </div>

        </div>
    </div>
</div>

<?php
require_once '../template/footer.php';
?>