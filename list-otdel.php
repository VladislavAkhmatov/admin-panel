<?php
require_once 'secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
header('Location: 404.php');
exit();
}
$size = 1;
if (isset($_GET['page'])) {
$page = Helper::clearInt($_GET['page']);
} else {
$page = 1;
}
$otdelMap = new OtdelMap();
$count = $otdelMap->count();
$arrOtdels = $otdelMap->findAll($page*$size-$size, $size);
$header = 'Список отделов';
require_once 'template/header.php';
?>
<div class="row">
<div class="col-xs-12">
<div class="box">
<section class="content-header">
<h1><?=$header;?></h1>
<ol class="breadcrumb">
<li><a href="/index.php"><i class="fafa-dashboard"></i> Главная</a></li>
<li class="active"><?=$header;?></li>
</ol>
</section>
<div class="box-body">
<a class="btn btn-success" href="add-otdel.php">Добавить отдел</a>
</div>
<div class="box-body">
<?php
if ($arrOtdels) {
?>
<table id="example2" class="table table-bordered table-hover">
<thead>
<tr>
<th>Название</th>
</tr>
</thead>
<tbody>
<?php
foreach ($arrOtdels as $otdel) {
echo '<tr>';
echo '<td><a href="view-otdel.php?id='.$otdel->otdel_id.'">'.$otdel->name.'</a> '
. '<a href="add-otdel.php?id='.$otdel->otdel_id.'"><i class="fa fa-pencil"></i></a></td>';
}
?>
</tbody>
</table>
<?php } else {
echo 'Ни одного отдела не найдено';
} ?>
</div>
<div class="box-body">
<?php Helper::paginator($count, $page,
$size); ?>
</div>
</div>
</div>
</div>
<?php
require_once 'template/footer.php';
?>