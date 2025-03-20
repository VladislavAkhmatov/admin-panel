<?php
require_once '../secure.php';

if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
$size = 10;
$user_id = null;
$subject_id = null;
if (isset($_GET['user_id']) && isset($_GET['subject_id'])) {
    $user_id = $_GET['user_id'];
    $subject_id = $_GET['subject_id'];
} else {
    header('Location: 404');
    exit();
}

$gradesInfo = (new ProcreatorMap())->findPerformanceBygradesInfo($user_id, $subject_id);
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
                                    foreach ($gradesInfo as $item) {
                                        echo '<th>' . Helper::formattedData($item->date) . '</th>';
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Генерация строк по категориям
                                $categories = ["Присутствовал", "Домашнее задание", "Активность"];
                                foreach ($categories as $category) {
                                    echo "<tr>";
                                    echo "<td><b>$category</b></td>";

                                    // Генерация ячеек для каждой даты
                                    foreach ($gradesInfo as $item) {
                                        // В зависимости от категории выводим соответствующее значение
                                        switch ($category) {
                                            case "Присутствовал":
                                                echo $item->attend == 1 ? "<td>Б</td>" : "<td>Н</td>";
                                                break;
                                            case "Домашнее задание":
                                                echo $item->homework != NULL ? "<td>$item->homework</td>" : "<td>-</td>";
                                                break;
                                            case "Активность":
                                                echo $item->activity != 0 ? "<td>$item->activity</td>" : "<td>-</td>";
                                                break;
                                            default:
                                                echo "<td></td>";
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