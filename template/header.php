<?php
$procreatorMap = new ProcreatorMap();
$notices = $procreatorMap->notice();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?= ($header) ? $header : 'Расписание занятий'; ?>
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/template/css/bootstrap.min.css">
  <link rel="stylesheet" href="/template/css/font-awesome.min.css">
  <link rel="stylesheet" href="/template/css/ionicons.min.css">
  <link rel="stylesheet" href="/template/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/template/css/skins/skin-blue.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Р</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Расписание</b></span>
      </a>
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <?php if (Helper::can('procreator')) { ?>

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">
                    <?php echo $procreatorMap->noticeCount(); ?>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">
                    <?php if ($procreatorMap->noticeCount() == 0) {
                      echo 'У вас нет уведомлений';
                    } else { ?>
                      У вас
                      <?php echo $procreatorMap->noticeCount(); ?>
                      Уведомлений(я)
                    <?php } ?>
                  </li>
                  <li class="header">
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php if ($notices) { ?>
                        <?php foreach ($notices as $item) {
                          $text = "Оплатите сумму указанную в приложении";
                          if (strtolower($item->text) == strtolower($text)) {
                            $text = mb_substr($text, 8);
                            ?>

                            <a href="../add/add-payment?id=<?= $item->id; ?>">
                              <li>
                                Оплатите
                                <b>
                                  за
                                  <?= $item->child ?>
                                  по предмету

                                  <?= $item->subject ?>
                                </b>
                                <?= $text ?> до <b>
                                  <?= $item->date ?> по ссылке

                                </b>
                                <?= $item->link ?>
                              </li>
                            </a><br>
                          <?php } elseif ($item->canceled == 1) {
                            ?>
                            <a href="../add/add-payment?id=<?= $item->id; ?>">
                              <li>
                                Ваша оплата
                                <b>
                                  за
                                  <?= $item->child ?>
                                </b>
                                по предмету
                                <b>
                                  <?= $item->subject ?>
                                </b>
                                Отменена по причине
                                <b>
                                  <?= $item->text ?>
                                </b>
                              </li>
                            </a><br>
                            <?php
                          } else {
                            ?>
                            <a href="../add/add-payment?id=<?= $item->id; ?>">
                              <li>
                                <?= $item->text ?>
                                <b>
                                  <?= $item->child ?>
                                  <?= $item->subject ?>
                                  до
                                  <?= $item->date ?>
                                  по ссылке
                                </b>
                                <?= $item->link ?><br>
                              </li>
                            </a><br>

                            <?php
                          }
                          ?>
                        <?php } ?>
                      <?php } ?>
                    </ul>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <?php ?>
                <span class="hidden-xs">Здравствуйте,
                  <?= $_SESSION["fio"] ?>

                </span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <p>
                    <?= $_SESSION["fio"] ?> -
                    <small>
                      <?= $_SESSION['roleName'] ?>
                    </small>
                    <img style="width: 75px; height: 75px;" src="../avatars/<?= $_SESSION['photo'] ?>">
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <form method="POST">
                  <button type="submit" class="btn btn-default btn-flat" name="out">Выход</button>
                </form>
              </div>
              <div class="pull-left">
                <a href="../add/add-avatar" class="btn btn-default btn-flat">Изменить фото</a>
              </div>
            </li>
          </ul>
          </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->


        <!-- search form (Optional) -->

        <!-- /.search form -->
        <?php require_once 'menu.php'; ?>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">


      </section>

      <!-- Main content -->
      <section class="content container-fluid">