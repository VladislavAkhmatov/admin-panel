<?php
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li <?= ($_SERVER['PHP_SELF'] == '/index.php') ? 'class="active"' : ''; ?>>

                <a href="../index"><i class="fa fa-calendar"></i><span>Главная</span></a>

            </li>
            <?php if (Helper::can('manager')) { ?>
                <li class="header">Пользователи</li>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-student.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-student"><i class="fa fa-users"></i><span>Ученики</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-teacher"><i class="fa fa-users"></i><span>Учителя</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-parent.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-parent"><i class="fa fa-users"></i><span>Родители</span></a>
                <li class="header">Справочники</li>



                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-gruppa.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-gruppa"><i class="fa fa-object-group"></i><span>Группы</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-otdel.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-otdel"><i class="fa fa-building"></i><span>Отделы</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-time.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-time"><i class="fa fa-clock-o"></i><span>Время</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-subject.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-subject"><i class="fa fa-sitemap"></i><span>Предметы</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-classroom.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-classroom"><i class="fa fa-graduation-cap"></i><span>Кабинеты</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/select-subject.php') ? 'class="active"' : ''; ?>>

                    <a href="../select-subject"><i class="fa fa-book"></i><span>Журнал</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/add/add-payment.php') ? 'class="active"' : ''; ?>>

                    <a href="../select-parent"><i class="fa fa-dollar"></i><span>Создать оплату</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/check/check-payment.php') ? 'class="active"' : ''; ?>>

                    <a href="../check/check-payment"><i class="fa fa-dollar"></i><span>Подтверждение оплаты</span></a>

                <li <?= ($_SERVER['PHP_SELF'] == '/view/view-payment.php') ? 'class="active"' : ''; ?>>

                    <a href="../view/view-payment"><i class="fa fa-dollar"></i><span>Сверка оплаты</span></a>
                <li <?= ($_SERVER['PHP_SELF'] == '/check/check-grades.php') ? 'class="active"' : ''; ?>>

                    <a href="../check/check-grades"><i class="fa fa-table"></i><span>Подтверждение оценок</span></a>
                <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher-schedule.php') ? 'class="active"' : ''; ?>>

                    <a href="../list/list-teacher-schedule"><i class="fa fa-table"></i><span>Управление
                            расписанием</span></a>

                </li>
            <?php } ?>
            <?php if (Helper::can('teacher')) { ?>
            <li class="header">Пользователи</li>


            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-student.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-student"><i class="fa fa-users"></i><span>Студенты</span></a>
            <li class="header">Справочники</li>
            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-gruppa.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-gruppa"><i class="fa fa-object-group"></i><span>Группы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-homework.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-homework"><i class="fa fa-home"></i><span>Домашнее задание</span></a>

                <?php } ?>

                <?php if (Helper::can('admin')) { ?>
            <li class="header">Пользователи</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-manager.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-manager"><i class="fa fa-users"></i><span>Администраторы</span></a>


            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-student.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-student"><i class="fa fa-users"></i><span>Ученики</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-teacher"><i class="fa fa-users"></i><span>Учителя</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-parent.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-parent"><i class="fa fa-users"></i><span>Родители</span></a>

            <li class="header">Справочники</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-branch.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-branch"><i class="fa fa-code-fork"></i><span>Филиалы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-gruppa.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-gruppa"><i class="fa fa-object-group"></i><span>Группы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-otdel.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-otdel"><i class="fa fa-building"></i><span>Отделы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-time.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-time"><i class="fa fa-clock-o"></i><span>Время</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-subject.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-subject"><i class="fa fa-sitemap"></i><span>Предметы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-classroom.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-classroom"><i class="fa fa-graduation-cap"></i><span>Кабинеты</span></a>

            </li>
            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-grades.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-grades"><i class="fa fa-book"></i><span>Журнал</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/select-subject.php') ? 'class="active"' : ''; ?>>

                <a href="../select-subject"><i class="fa fa-address-book"></i><span>Оценки</span></a>
            <li <?= ($_SERVER['PHP_SELF'] == '/view/view-payment.php') ? 'class="active"' : ''; ?>>

                <a href="../view/view-payment"><i class="fa fa-dollar"></i><span>Сверка оплаты</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher-schedule.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-teacher-schedule"><i class="fa fa-table"></i><span>Управление
                            расписанием</span></a>

                <?php } ?>

                <?php if (Helper::can('procreator')) { ?>

            <li class="header">Справочники</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-performance.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-performance"><i class="fa fa-address-book"></i><span>Успеваемоcть</span></a>
            <li <?= ($_SERVER['PHP_SELF'] == '/view/view-notice.php') ? 'class="active"' : ''; ?>>

                <a href="../view/view-notice"><i class="fa fa-usd"></i><span>Оплата</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-control.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-control"><i class="fa fa-usd"></i><span>Контроль оплаты</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-homework.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-homework"><i class="fa fa-home"></i><span>Домашнее задание</span></a>

                <?php } ?>
        </ul>
    </section>
</aside>