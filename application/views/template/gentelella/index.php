<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('template/gentelella/head'); ?>
	<style type="text/css">
		.nav.child_menu>li>a, .nav.side-menu>li>a, .profile_info {
			text-shadow: 1px 1px #000;
		}
		footer {
		    border-top: 1px solid #ddd;
		    padding: 10px 20px;
		}
	</style>
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php $this->load->view('template/gentelella/menu'); ?>
			<?php $this->load->view('template/gentelella/header'); ?>
			

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">

					<?php $this->load->view('template/gentelella/notification') ?>

					<div class="clearfix"></div>
					<?php $this->load->view($content); ?>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Hanief Studio &copy; 2018
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<?php $this->load->view('template/gentelella/foot'); ?>
</body>
</html>