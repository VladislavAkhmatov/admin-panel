<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin') && !Helper::can('teacher')) {
    header('Location: 404');
    exit();
}
$size = 10;
if (isset ($_GET['page'])) {
    $page = Helper::clearInt($_GET['page']);

} else {
    $page = 1;
}
$parentMap = new ProcreatorMap();
$count = $parentMap->count();
$parent = $parentMap->findAll($page * $size - $size, $size);
require_once '../template/header.php';
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <section class="content-header">
                    <h3><b>
                            <?=
                            $header = isset ($_GET['q']) ? Helper::message($_GET['q']) : 'Список родителей';
                            ?>
                        </b></h3>
                    <ol class="breadcrumb">
                        <li><a href="../index"><i class="fa
fa-dashboard"></i> Главная</a></li>
                        <li class="active">Список
                            родителей
                        </li>
                    </ol>
                </section>
                <div class="box-body">
                    <a class="btn btn-success" href="../add/add-parent?k=parent">Добавить родителя</a>
                </div>

                <div class="box-body">
                    <a class="btn btn-success" href="../add/add-child-parent">Добавить ученика к родителю</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php
                    if ($parent) {
                        ?>

                        <table id="example2" class="table table-bordered table-hover">

                            <thead>
                            <tr>
                                <th>Ф.И.О</th>
                                <th>Дата рождения</th>
                                <th>Ученик</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($parent as $parent) {
                                echo '<tr>';
                                echo '<td><a href="../profile/profile-parent?id=' . $parent->user_id . '">' . $parent->parent_fio . '</a> ' . '<a href="../add/add-parent?k=parent&id=' . $parent->user_id . '"><i class="fa fa-pencil"></i></a> <a href="../delete/delete-parent?id=' . $parent->user_id . '"><i class="fa fa-times"></i></a></td>';
                                echo '<td>' . Helper::formattedData($parent->birthday) . '</td>';
                                echo '<td>';
                                foreach ((new ProcreatorMap())->findStudentFromParentId($parent->user_id) as $item) {
                                    echo ' 
                                         <form action="../delete/delete-parent-child" method="post">
                                         ' . $item->child . ' 
                                            <button style="all: unset; cursor: pointer" type="submit"><i class="fa fa-times"></i></button>
                                            <input type="hidden" value="' . $parent->user_id . '" name="parent_id">
                                            <input type="hidden" value="' . $item->user_id . '" name="child_id">
                                         </form>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
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
require_once '../template/footer.php';
?>