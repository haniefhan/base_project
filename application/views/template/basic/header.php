<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url_admin() ?>"><?php echo $this->session->userdata('site_title') ?></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<?php $menus = $this->session->userdata('menus');?>

			<ul class="nav navbar-nav">
				<?php foreach ($menus as $i => $menu) { ?>
					<?php if(!isset($menu['children'])){ ?>
						<li>
							<a href="<?php echo base_url_admin().$menu['url'] ?>"><?php echo lang($menu['name']) ?></a>
						</li>
					<?php }else{ ?>
						<li class="dropdown">
							<a href="<?php echo base_url_admin().$menu['url'] ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<?php echo lang($menu['name']) ?> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<?php foreach ($menu['children'] as $j => $menu) {?>
									<li><a href="<?php echo base_url_admin().$menu['url'] ?>"><?php echo lang($menu['name']) ?></a></li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
				<?php } ?>
				<li>
					<a href="<?php echo base_url_admin().'login/signout' ?>"> Sign Out</a>
				</li>
			</ul>
		</div><!--/.nav-collapse -->	
	</div>
</nav>