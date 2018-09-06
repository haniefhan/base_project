<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $this->session->userdata('site_title').' | '.$title; ?></title>
		<!-- Bootstrap -->
		<link href="<?php echo asset_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo asset_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo asset_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo asset_url(); ?>build/css/custom.min.css" rel="stylesheet">
		<style type="text/css">
			.nav-md .container.body .right_col {
				margin-left: 0;
			}
			.nav-sm .container.body .right_col {
				margin-left: 0;
			}
			footer {
				border-top: 1px solid #d2d6de;
			}
			@media (min-width: 992px){
				footer {
				margin-left: 0px;
				}
			}
			.nav-sm footer {
				margin-left: 0px;
			}
			/*.nav_menu {
			    background: #2A3F54;
			    border-bottom: 3px solid #009688;
			}*/
			.navbar-static-top {
			    background: #34495e;
			    border-bottom: 3px solid #009688;
			    padding-left: 10px;
				padding-right: 10px;
			}
			.nav-md .container.body .right_col {
				padding-top: 20px;
			}
			.nav-md .container.body .right_col, .nav-md .container.body .top_nav {
				margin-top: 50px;
			}
			body .container.body .right_col {
			    background: #ecf0f5;
			}
			.nav.navbar-nav>li>a {
			    color: #ffffff!important;
			}
			.nav.navbar-nav>li>a:hover {
			    color: #009688!important;
			}
		</style>
	</head>
	
	<body class="nav-md">
		<div class="container body">
			<div class="">
				<div class="top_nav">
					<header class="main-header">
						<nav class="navbar navbar-static-top">
							<div class="container">
								<div class="navbar-header">
									<a href="<?php echo base_url_admin(); ?>" class="navbar-brand"><b>APLIKASI PENUNJANG KINERJA DAN NOTULENSI</b></a>
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
									<i class="fa fa-bars"></i>
									</button>
								</div>
								<div class="collapse navbar-collapse pull-right" id="navbar-collapse">
									<ul class="nav navbar-nav">
										<li class="active"><a href="<?php echo base_url_admin(); ?>">Beranda</a></li>
										<li><a href="<?php echo base_url_admin(); ?>login">Log In</a></li>
									</ul>
								</div>
							</div>
						</nav>
					</header>
				</div>
				<div class="right_col" role="main">
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
							<div class="x_panel">
								<div class="x_content">
									<?php if($this->session->flashdata() != NULL){ ?>
									<div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('notif_msg') ?>
									</div>
									<?php } ?>
									<form action="<?php echo base_url_admin(); ?>login/signin" class="form-horizontal" method="POST">
										<br />
										<h4 class="text-center">Silahkan Login</h4>
										<br />
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" class="form-control" placeholder="Username" name="username" required />
												<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="password" class="form-control" placeholder="password" name="password" required />
												<span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
											</div>
										</div>
										<?php if($this->session->userdata('login_attempt') > 1){ ?>
										<div class="text-center">
											<img id="captcha" src="<?php echo base_url_admin().'login/gen_captcha' ?>" alt="CAPTCHA Image" />
										</div>
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="captcha_code" maxlength="6" style="" placeholder="Captcha" class="form-control" required />
											</div>
										</div>
										<?php } ?>
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<button class="btn btn-primary submit btn-block form-control">Log in</button>
											</div>
										</div>
										<br />
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer>
					<div class="text-center">
						Dinas Komunikasi dan Informatika &copy; 2018.
					</div>
					<div class="clearfix"></div>
				</footer>
			</div>
		</div>
		<!-- jQuery -->
		<script src="<?php echo asset_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="<?php echo asset_url(); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo asset_url(); ?>vendors/fastclick/lib/fastclick.js"></script>
		<!-- NProgress -->
		<script src="<?php echo asset_url(); ?>vendors/nprogress/nprogress.js"></script>
		<!-- Custom Theme Scripts -->
		<script src="<?php echo asset_url(); ?>build/js/custom.min.js"></script>
	</body>
</html>