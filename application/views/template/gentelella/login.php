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
		<link href="<?php echo asset_admin_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo asset_admin_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo asset_admin_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- Animate.css -->
		<link href="<?php echo asset_admin_url(); ?>vendors/animate.css/animate.min.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo asset_admin_url(); ?>build/css/custom.min.css" rel="stylesheet">
		<link rel="shortcut icon" href="<?php echo $this->session->userdata('logo'); ?>">
	</head>
	<body class="login">
		<div>
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="signin"></a>
			<div class="login_wrapper">
				<div class="animate form login_form">
					<section class="login_content">
						<form action="<?php echo base_url_admin(); ?>login/signin" method="POST">
							<h1>Silahkan Login</h1>
							<div>
								<input name="username" type="text" class="form-control" placeholder="Username" required="required" id="username"/>
							</div>
							<div>
								<input name="password" type="password" class="form-control" placeholder="Password" required="required" />
							</div>
							<?php if($this->session->userdata('login_attempt') > 1){ ?>
							<div class=" text-center">
								<img id="captcha" src="<?php echo base_url_admin().'login/gen_captcha' ?>" alt="CAPTCHA Image" />
								<input type="text" name="captcha_code" maxlength="6" style="" placeholder="Captcha" class="form-control" />
							</div>
							<?php } ?>
							<div>
								<button class="btn btn-primary submit form-control">Log in</button>
							</div>
						</form>
					</section>
					<?php if($this->session->flashdata() != NULL){ ?>
					<div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable col-lg-12">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $this->session->flashdata('notif_msg') ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			window.onload = function() {
			  var input = document.getElementById("username").focus();
			}
		</script>
	</body>
</html>