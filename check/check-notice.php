<?php
require_once '../secure.php';
if (!Helper::can('procreator')) {
    header('Location: 404');
    exit();
}

$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$procreatorMap = new ProcreatorMap();
$notices = $procreatorMap->noticeById($id);
$header = 'Уведомление';
require_once '../template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="content-header">
                <h3><b>
                        <?= $message = isset($_GET['message']) ? Helper::getQuery($_GET['message']) : 'Уведомление'; ?>
                    </b></h3>
                <ol class="breadcrumb">
                    <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
                    <li class="active">Уведомление</li>
                </ol>
            </section>
            <div class="box-body">
                <?php
                foreach ($notices as $notice) {
                    if ($notice->id == $id) {
                        echo "<p style='font-size: 16px;'>" . $notice->text . "</p>";
                        echo "<b style='font-size: 16px;'>" . $notice->child . " -> " . $notice->subject . " -> " .
                            $notice->date . "</b>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../template/footer.php';