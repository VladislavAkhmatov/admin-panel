<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}
require_once '../template/header.php';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> Главная</li>
                    <li>Успеваемость</li>
                </ol>
            </section>
            <div class="box-body">
            </div>
            <form action="../view/view-performance" method="POST">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ф.И.О ученика</th>
                            <th>Предмет</th>
                            <th>Филиал</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select style="width: 300px;" class="form-control" name="user_id">
                                    <?= Helper::printSelectOptions(0, (new ProcreatorMap())->arrChildsByParent()); ?>
                                </select>
                            </td>
                            <td>
                                <select style="width: 300px;" class="form-control" name="subject_id">
                                    <?= Helper::printSelectOptions(0, (new SubjectMap())->arrSubjects()); ?>
                                </select>
                            </td>
                            <td>
                                <select style="width: 300px;" class="form-control" name="branch_id">
                                    <?= Helper::printSelectOptions(0, (new UserMap())->arrBranchs()); ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="box-body">
                    <button type="submit" name="savePayment" class="btn btn-primary">Выполнить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php';
?>