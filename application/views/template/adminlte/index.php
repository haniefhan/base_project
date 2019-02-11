<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('template/adminlte/head'); ?>
</head>
<body class="hold-transition <?php echo $this->session->userdata('template_admin_color'); ?> sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view('template/adminlte/header'); ?>
		<?php $this->load->view('template/adminlte/menu'); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1><?php echo $title; ?></h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url_admin(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<?php foreach ($breadcrumb as $bc) { ?>
						<li><a href="<?php echo $bc['url'] ?>" class="active"><?php echo $bc['name'] ?></a></li>
					<?php } ?>
					<!-- <li><a href="#">Forms</a></li>
					<li class="active">General Elements</li> -->
				</ol>
			</section>
			<section class="content">
				<?php $this->load->view('template/adminlte/notification') ?>
				<?php $this->load->view($content); ?>
			</section>
		</div>
		<footer class="main-footer">
			<!-- <div class="pull-right hidden-xs">
				<b>Version</b> 2.4.0
			</div> -->
			<?php 
				$copyright_year_start = 2018;
				$copyright_year_text = $copyright_year_start;
				if(date('Y') > $copyright_year_start){
					$copyright_year_text .= ' - '.date('Y');
				}
			?>
			<strong>Copyright &copy; <?php echo $copyright_year_text; ?> <a href="#">Hanief Studio</a>.</strong> All rights
			reserved.
		</footer>
		<div class="control-sidebar-bg"></div>
	</div>

	<?php $this->load->view('template/adminlte/foot'); ?>
</body>
</html>