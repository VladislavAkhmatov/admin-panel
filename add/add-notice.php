<?php
require_once '../secure.php';
if (!Helper::can('admin')) {
    header('Location: 404');
    exit();
}
$id = 0;
if (isset($_GET['id'])) {
    $id = Helper::clearInt($_GET['id']);
}
$userMap = new UserMap();


require_once '../template/header.php';
?>

<section class="content-header">
    <h3>
        <b>
            <?= $message; ?>
        </b>
    </h3>
    <ol class="breadcrumb">
        <li><a href="../index"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li>Уведомления</li>
    </ol>
</section>
<?php if (!isset($_POST['child_id'])): ?>

    <form method="post">
        <div class="form-group">
            <label>Для кого</label>
            <div class="form-group">
                <select class="form-control" name="child_id">
                    <?php Helper::printSelectOptions(0, (new ProcreatorMap())->arrChildsByParentId($id)) ?>
                </select>
            </div>
            <input type="hidden" name="user_id" value=<?= $id ?>>
            <div class="form-group">
                <button type="submit" name="confirm" class="btn btn-primary">Подтвердить оплату за родителя</button>
            </div>
            <div class="form-group">
                <button type="submit" name="create" class="btn btn-primary">Создать оплату</button>
            </div>
        </div>
    </form>

<?php elseif (isset($_POST['child_id']) && isset($_POST['create'])): { ?>

        <form action="../save/save-notice" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Текст уведомления</label>
                <input class="form-control" type="text" name="text" value="Оплатите сумму указанную в приложении">
            </div>

            <div class="form-group">
                <label>Предмет</label>
                <select class="form-control" name="subject_id">
                    <?php Helper::printSelectOptions(0, (new SubjectMap())->arrSubjects()) ?>
                </select>
            </div>

            <div class="form-group">
                <label>Сумма за один урок</label>
                <input class="form-control" type="number" id="subject_sum" oninput="calculateSum()" required>
            </div>

            <div class="form-group">
                <label>Кол-во уроков</label>
                <input class="form-control" type="number" name="subject_count" id="input1" oninput="calculateSum()" required>
            </div>

            <div class="form-group">
                <label>Кол-во пропусков по ув. причине</label>
                <input class="form-control" type="number" name="reason" id="input2" oninput="calculateSum()">
            </div>

            <div class="form-group">
                <label>Ссылка</label>
                <input class="form-control" type="text" name="link" value="https://pay.kaspi.kz/pay/wndzlf4x">
                <input type="hidden" name="link" value="https://pay.kaspi.kz/pay/wndzlf4x">
            </div>

            <div class="form-group">
                <label>Сумма</label>
                <input type="hidden" name="subject_price">
                <span id="sum"></span>
            </div>

            <div class=" form-group">
                <label>Оплатить до</label>
                <input class="form-control" type="date" class="form-control" name="date" required>
            </div>

            <input type="hidden" name="user_id" value=<?= $_POST['user_id']; ?>>
            <input type="hidden" name="child_id" value=<?= $_POST['child_id']; ?>>
            <div class="form-group">
                <button type="submit" name="saveNotice" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

    <?php } ?>

<?php elseif (isset($_POST['child_id']) && isset($_POST['confirm'])): { ?>
        <form action="../save/save-notice" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Предмет</label>
                <select class="form-control" name="subject_id">
                    <?php Helper::printSelectOptions(0, (new SubjectMap())->arrSubjects()) ?>
                </select>
            </div>

            <div class="form-group">
                <label>Сумма за один урок</label>
                <input class="form-control" type="number" id="subject_sum" oninput="calculateSum()" required>
            </div>

            <div class="form-group">
                <label>Кол-во уроков</label>
                <input class="form-control" type="number" name="subject_count" id="input1" oninput="calculateSum()" required>
            </div>

            <div class="form-group">
                <label>Кол-во пропусков по ув. причине</label>
                <input class="form-control" type="number" name="reason" id="input2" oninput="calculateSum()">
            </div>

            <div class="form-group">
                <label>Сумма</label>
                <input type="hidden" name="subject_price">
                <span id="sum"></span>
            </div>
            <div class="form-group">
                <label>Способ оплаты</label>
            </div>
            <div class="form-group">
                <input type="radio" name="payment_method" value="Наличные">
                <label>Наличные</label>

                <input type="radio" name="payment_method" value="QR">
                <label>QR</label>

                <span id="sum"></span>
            </div>

            <input type="hidden" name="user_id" value=<?= $_POST['user_id']; ?>>
            <input type="hidden" name="child_id" value=<?= $_POST['child_id']; ?>>
            <div class="form-group">
                <button type="submit" name="saveNoticeForParent" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    <?php } ?>
<?php endif; ?>
<script>
    function calculateSum() {
        var input1 = parseFloat(document.getElementById("input1").value);
        var input2 = parseFloat(document.getElementById("input2").value);
        var subjectSum = parseFloat(document.getElementById("subject_sum").value);

        // Проверка на isNaN для input1, input2 и subjectSum
        if (isNaN(input1) || input1 < 0) {
            input1 = 0; // Если input1 NaN или меньше нуля, присвоить ему значение 0
        }
        if (isNaN(input2) || input2 < 0) {
            input2 = 0; // Если input2 NaN или меньше нуля, присвоить ему значение 0
        }
        if (isNaN(subjectSum) || subjectSum < 0) {
            subjectSum = 0; // Если subjectSum NaN или меньше нуля, присвоить ему значение 0
        }

        var sum = input1 * subjectSum;
        var sum2 = input2 * 1250;
        var sum3 = sum - sum2;

        if (sum2 == 0) {
            document.getElementsByName("subject_price")[0].value = sum;
            document.getElementById("sum").textContent = sum + "₸";
        } else {
            document.getElementsByName("subject_price")[0].value = sum3;
            document.getElementById("sum").textContent = sum3 + "₸";
        }
    }
</script>
<?php
require_once '../template/footer.php';
?>