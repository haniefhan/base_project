<style type="text/css">
	.navbar-nav .open .dropdown-menu.msg_list {
	    max-height: 450px;
	    overflow-y: auto;
	}
	ul.msg_list li a .time {
		right: 10px;
	}
	.toggle {
		width: 12%;
	}
	.top_nav .navbar-right {
		width: 88%;
	}
	.running-text {
	    position: fixed;
	    bottom: 0px;
	    background: #000;
	    width: 100%;
	    height: 25px;
	    z-index: 10;
	}
</style>
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="<?php echo asset_admin_url().'production/images/tester.png'; ?>" alt=""><?php echo $this->session->userdata('name') ?>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="<?php echo base_url_admin().'profile' ?>"> Profile</a></li>
						<!-- <li>
							<a href="javascript:;">
								<span class="badge bg-red pull-right">50%</span>
								<span>Settings</span>
							</a>
						</li>
						<li><a href="javascript:;">Help</a></li> -->
						<li><a href="<?php echo base_url_admin().'login/signout' ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>
				<li role="presentation" class="dropdown">
					<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-envelope-o"></i>
						<?php if($notification['new'] > 0){ ?>
							<span class="badge bg-green"><?php echo $notification['new']; ?></span>
						<?php } ?>
					</a>
					<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
						<?php foreach ($notification['datas'] as $data) {?>
							<li>
								<a href="<?php echo base_url_admin().'notification/read?id='.$data['ntf_id']; ?>">
									<span>
										<span><?php echo $data['ntf_title']; ?></span>
										<span class="time" title="<?php echo date('d/m/Y H:i', strtotime($data['create_date'])); ?>"><?php echo $data['ago']; ?></span>
									</span>
									<span class="message"><?php echo $data['ntf_content']; ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>