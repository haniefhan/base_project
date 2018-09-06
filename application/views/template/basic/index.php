<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php echo $this->session->userdata('logo') ?>">

	<title><?php echo $this->session->userdata('site_title'). ' | ' .$title ?></title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo asset_admin_url() ?>dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="<?php echo asset_admin_url() ?>dist/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?php echo asset_admin_url() ?>css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?php echo asset_admin_url() ?>css/theme.css" rel="stylesheet">

	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="<?php echo asset_admin_url() ?>js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="<?php echo asset_admin_url() ?>js/ie-emulation-modes-warning.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- [if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif] -->
</head>
<body>
	<?php $this->load->view('template/basic/header'); ?>
	<div class="container theme-showcase" role="main">
		<?php $this->load->view($content); ?>
	</div> <!-- /container -->
	<?php $this->load->view('template/basic/footer'); ?>
</body>
</html>