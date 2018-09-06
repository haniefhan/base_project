<?php if($this->session->flashdata() != NULL){ ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h5 style="margin: 0"><?php echo $this->session->flashdata('notif_msg') ?></h5>
		</div>
	</div>
</div>
<?php } ?>