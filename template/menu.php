<?php
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li <?= ($_SERVER['PHP_SELF'] == '/index.php') ? 'class="active"' : ''; ?>>

                <a href="../index"><i class="fa fa-calendar"></i><span>Главная</span></a>

            </li>
            <?php if (Helper::can('admin')) { ?>
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

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-subject.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-subject"><i class="fa fa-sitemap"></i><span>Предметы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-classroom.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-classroom"><i class="fa fa-graduation-cap"></i><span>Кабинеты</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/select-schedule.php') ? 'class="active"' : ''; ?>>

                <a href="../select-schedule.php"><i class="fa fa-address-book"></i><span>Оценки</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher-schedule.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-teacher-schedule"><i class="fa fa-table"></i><span>Управление
                            расписанием</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/select-balance.php') ? 'class="active"' : ''; ?>>

                <a href="../select-balance"><i class="fa fa-table"></i><span>Баланс уроков</span></a>
            </li>
            <li class="header">Архивы</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/archive-teacher.php') ? 'class="active"' : ''; ?>>

                <a href="../archive/archive-teacher"><i class="fa fa-table"></i><span>Архив преподавателей</span></a>

                <?php } ?>
                <?php if (Helper::can('teacher')) { ?>
            <li class="header">Пользователи</li>


            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-student.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-student"><i class="fa fa-users"></i><span>Студенты</span></a>
            <li class="header">Справочники</li>
            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-gruppa.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-gruppa"><i class="fa fa-object-group"></i><span>Группы</span></a>

                <?php } ?>

                <?php if (Helper::can('owner')) { ?>
            <li class="header">Пользователи</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-admin.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-admin"><i class="fa fa-users"></i><span>Администраторы</span></a>


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

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-subject.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-subject"><i class="fa fa-sitemap"></i><span>Предметы</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-classroom.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-classroom"><i class="fa fa-graduation-cap"></i><span>Кабинеты</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/select-schedule.php') ? 'class="active"' : ''; ?>>

                <a href="../select-schedule"><i class="fa fa-address-book"></i><span>Оценки</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/list/list-teacher-schedule.php') ? 'class="active"' : ''; ?>>

                <a href="../list/list-teacher-schedule"><i class="fa fa-table"></i><span>Управление
                            расписанием</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/select-balance.php') ? 'class="active"' : ''; ?>>

                <a href="../select-balance"><i class="fa fa-table"></i><span>Баланс уроков</span></a>

            <li class="header">Архивы</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/archive-teacher.php') ? 'class="active"' : ''; ?>>

                <a href="../archive/archive-teacher"><i class="fa fa-table"></i><span>Архив преподавателей</span></a>
                <?php } ?>

                <?php if (Helper::can('procreator')) { ?>

            <li class="header">Справочники</li>

            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-performance.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-performance"><i class="fa fa-address-book"></i><span>Успеваемоcть</span></a>
            <li <?= ($_SERVER['PHP_SELF'] == '/view/view-notice.php') ? 'class="active"' : ''; ?>>

                <a href="../view/view-notice"><i class="fa fa-usd"></i><span>Оплата</span></a>

            <li <?= ($_SERVER['PHP_SELF'] == '/check/check-control.php') ? 'class="active"' : ''; ?>>

                <a href="../check/check-control"><i class="fa fa-usd"></i><span>Контроль оплаты</span></a>

                <?php } ?>
        </ul>
    </section>
</aside>