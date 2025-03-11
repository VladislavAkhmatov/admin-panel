<?php
require_once '../secure.php';
if (!Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
if (isset($_GET['id'])) {
    $_SESSION['child_id'] = $_GET['id'];
}
$gruppa = new GruppaMap();
$arrGruppas = $gruppa->arrGruppas();
$header = 'Список студентов';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Домашнее задание'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                    <li class="active">Домашнее задание</li>
                </ol>
            </section>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                if ($arrGruppas) {
                    ?>

                    <table id="example2" class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Ф.И.О</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($arrGruppas as $arrGruppas) {
                                echo '<tr>';
                                echo '<td><a href="../view/view-parent-homework?id=' . $arrGruppas['id'] . '">' . $arrGruppas['value'] . '</a> ' . '</td>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo 'Ни одного домашнего задания не найдено';
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';

?>