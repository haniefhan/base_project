<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('site_title').' | '.$title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo asset_admin_url(); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo asset_admin_url(); ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo asset_admin_url(); ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo asset_admin_url(); ?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo asset_admin_url(); ?>plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="shortcut icon" href="<?php echo $this->session->userdata('logo'); ?>">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url() ?>"><?php echo $this->session->userdata('site_title'); ?></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <?php if($state == 'forgot'){ ?>
                <p class="login-box-msg">Masukan Email</p>
                <?php if($this->session->flashdata() != NULL){ ?>
                    <div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable col-lg-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('notif_msg') ?>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
                <form action="<?php echo base_url_admin(); ?>login/reset_password" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" required="required">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="<?php echo base_url_admin().'login' ?>" class="btn btn-default">Back to Login</a>
                        </div>
                        <div class="col-xs-2">&nbsp;</div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-danger btn-block btn-flat">Reset Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            <?php }elseif($state == 'change_password'){ ?>
                <p class="login-box-msg">Masukan Password Baru</p>
                <?php if($this->session->flashdata() != NULL){ ?>
                    <div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable col-lg-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('notif_msg') ?>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
                <form action="<?php echo base_url_admin(); ?>login/do_change_password" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group has-feedback">
                        <input type="hidden" name="code" value="<?php echo $code; ?>">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required="required">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">&nbsp;</div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-danger btn-block btn-flat">Change Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            <?php } ?>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?php echo asset_admin_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo asset_admin_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            var input = document.getElementById("username").focus();
        }
    </script>
</body>
</html>