<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IQ STUDY|вход</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/template/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="preconnect">
    <link rel="stylesheet" href="../css/AdminLTE.css">

</head>

<body class="hold-transition login-page">
    <div class="auth-background">
        <div class="login-box">
            <div class="login-logo">
                <img src="../img/logo.png" alt="Company Logo">
            </div>
            <div class="login-box-body">
                <h2>Добро пожаловать</h2>
                <h3><b>ATTENDANCE ONLINE</b></h3>
                <p class="login-box-msg">
                    <?= $message; ?>
                </p>
                <form action="auth" method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Логин" name="login">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Пароль" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- jQuery and Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>