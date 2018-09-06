<?php if($this->session->flashdata() != NULL){ ?>
<div class="alert alert-<?php echo $this->session->flashdata('notif_status') == true ? 'success' : 'danger' ; ?> text-center alert-dismissable col-lg-12">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo $this->session->flashdata('notif_msg') ?>
</div>
<?php } ?>