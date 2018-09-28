<div class="row" id="theme">
	<?php if(count($public) > 0){ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Public Template</h3>
		</div>
		<?php foreach ($public as $data) {?>
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
				<div class="box box-primary">
					<div class="box-header with-border"><h3 class="box-title"><?php echo ucwords(str_replace('_', ' ', $data['name'])); ?></h3></div>
					<div class="box-body">
						<img src="<?php echo base_url().'assets/'.$data['url'].'screenshot-home.png' ?>" class="screenshot" style="max-height: 100px;">
					</div>
					<div class="box-footer">
						<?php if($data['color'] != ''){ ?>
							<div class="btn-group pull-left color-theme">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<?php $arr_color = json_decode($data['color'], true); ?>
									<?php if(is_array($arr_color)){ foreach ($arr_color as $color) {?>
										<li>
											<a href="<?php echo base_url_admin().'theme/change_color?value='.$color['value'].'&type=public' ?>"><div class="pull-left" style="background-color: #<?php echo $color['color'] ?>"></div> <?php echo $color['name'] ?></a>
										</li>
									<?php }}?>
								</ul>
							</div>
						<?php } ?>
						<a href="<?php echo base_url_admin() ?>theme/index?type=examples&id=<?php echo $data['id'] ?>" class="btn btn-default">Doc</a>
						<?php if($data['url'] != $this->session->userdata('template_use')){ ?>
							<a href="<?php echo base_url_admin().'theme/update?id='.$data['id'].'&type='.$data['type'] ?>" class="btn btn-primary">Activate</a>
						<?php }else{ ?>
							<span class="btn btn-success" disabled="disabled">Activated</span>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Admin Template</h3>
	</div>
	<?php foreach ($admin as $data) {?>
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
			<div class="box box-primary">
				<div class="box-header with-border"><h3 class="box-title"><?php echo ucwords(str_replace('_', ' ', $data['name'])); ?></h3></div>
				<div class="box-body">
					<img src="<?php echo base_url().'assets/'.$data['url'].'screenshot-home.png' ?>" class="screenshot" style="max-height: 100px;">
				</div>
				<div class="box-footer">
					<?php if($data['color'] != ''){ ?>
						<div class="btn-group pull-left color-theme">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<?php $arr_color = json_decode($data['color'], true); ?>
								<?php if(is_array($arr_color)){ foreach ($arr_color as $color) {?>
									<li>
										<a href="<?php echo base_url_admin().'theme/change_color?value='.$color['value'].'&type=admin' ?>"><div class="pull-left" style="background-color: #<?php echo $color['color'] ?>"></div> <?php echo $color['name'] ?></a>
									</li>
								<?php }}?>
							</ul>
						</div>
					<?php } ?>
					<a href="<?php echo base_url_admin() ?>theme/index?type=examples&id=<?php echo $data['id'] ?>" class="btn btn-default">Doc</a>
					<?php if($data['url'] != $this->session->userdata('template_admin_use')){ ?>
						<a href="<?php echo base_url_admin().'theme/update?id='.$data['id'].'&type='.$data['type'] ?>" class="btn btn-primary">Activate</a>
					<?php }else{ ?>
						<span class="btn btn-success" disabled="disabled">Activated</span>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<style type="text/css">
	img.screenshot{
		width:100%;
	}
	div#theme div.box-footer{
		text-align: right;
	}

	div.color-theme ul li a div{
		width: 20px;
		height: 20px;
		margin-right: 10px;
		border: 1px solid #c4c4c4;
	}
</style>