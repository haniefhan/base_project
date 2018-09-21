
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php echo $this->session->userdata('logo'); ?>">
	<title><?php echo $this->session->userdata('site_title').' | '.$title; ?></title>
	<link href="<?php echo asset_admin_url(); ?>dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo asset_admin_url(); ?>css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="<?php echo asset_admin_url(); ?>css/signin.css" rel="stylesheet">
	<script src="<?php echo asset_admin_url(); ?>js/ie-emulation-modes-warning.js"></script>
</head>
<body>
	<div class="container">
		<form class="form-signin" action="<?php echo base_url_admin(); ?>login/signin" method="POST">
			<center>
				<img src="<?php echo $this->session->userdata('logo'); ?>" style="max-width:100px">
			</center>
			<h2 class="form-signin-heading">Please sign in</h2>
			<label class="sr-only" for="username">Username</label>
			<input id="username" name="username" class="form-control" placeholder="Username" required="required" autofocus="" type="text">
			<label class="sr-only" for="password">Password</label>
			<input id="password" name="password" class="form-control" placeholder="Password" required="required" type="password">
			<?php if($this->session->userdata('login_attempt') > 1){ ?>
			    <div class="form-group text-center">
			        <img id="captcha" src="<?php echo base_url_admin().'login/gen_captcha' ?>" alt="CAPTCHA Image" />
			        <input type="text" name="captcha_code" maxlength="6" style="" placeholder="Captcha"/>
			    </div>
			<?php } ?>
			<!-- <div class="checkbox">
				<label>
					<input value="remember-me" type="checkbox">
					Remember me
				</label>
			</div> -->
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<br/>
			<?php if($this->session->flashdata() != NULL){ ?>
			<div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable col-lg-12">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('notif_msg') ?>
			</div>
			<?php } ?>
		</form>
	</div>
	<script src="<?php echo asset_admin_url(); ?>js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>