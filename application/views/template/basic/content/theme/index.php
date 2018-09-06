<div class="row" id="theme">
	<div class="col-lg-12">
		<h3>Admin Template</h3>
	</div>
	<?php foreach ($admin as $data) {?>
		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo ucwords(str_replace('_', ' ', $data['name'])); ?></div>
				<div class="panel-body">
					<img src="<?php echo base_url().'assets/'.$data['url'].'screenshot-home.png' ?>" class="screenshot"  style="max-height: 100px;">
				</div>
				<div class="panel-footer">
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
	div#theme div.panel-footer{
		text-align: right;
	}
</style>