<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="<?php echo base_url_admin() ?>" class="site_title"><i class="fa fa-laptop"></i> <span><?php echo $this->session->userdata('site_title'); ?></span></a>
		</div>

		<div class="clearfix"></div>

		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="<?php echo asset_admin_url().'production/images/tester.png'; ?>" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Selamat Datang,</span>
				<h2><?php echo $this->session->userdata('name') ?></h2>
			</div>
		</div>
		<!-- /menu profile quick info -->

		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<?php $menus = $this->session->userdata('menus');?>
				<ul class="nav side-menu">
					<?php foreach ($menus as $i => $menu) { ?>
					<?php if(!isset($menu['children'])){ ?>
					<li>
						<a href="<?php echo base_url_admin().$menu['url'] ?>"><i class="<?php echo $menu['icon']; ?>"></i> <?php echo $menu['name'] ?> </a>
					</li>
					<?php }else{ ?>
					<li>
						<a href="#" onclick="return false;">
							<i class="<?php echo $menu['icon']; ?>"></i> <?php echo $menu['name'] ?> <span class="fa fa-chevron-down"></span>
						</a>
						<ul class="nav child_menu">
							<?php foreach ($menu['children'] as $j => $menu) {?>
							<li><a href="<?php echo base_url_admin().$menu['url'] ?>"><?php echo $menu['name'] ?></a></li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<?php } ?>
					<li>
						<a href="<?php echo base_url_admin().'login/signout' ?>"><i class="fa fa-sign-out"></i> Sign Out</a>
					</li>
				</ul>
			</div>

		</div>
		<!-- /sidebar menu -->
	</div>
</div>