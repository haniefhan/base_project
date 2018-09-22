<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">Theme Documentation</div>
			<div class="panel-body">
				<iframe src="<?php echo base_url().'assets/'.$data['url'].$data['example'] ?>" style="width:100%;height:400px"></iframe>
				<button type="button" class="btn btn-primary" onclick="goBack()">Back</button>
				<a href="<?php echo base_url_admin().'theme' ?>" class="btn btn-default">Back to Theme</a>
				<a href="<?php echo base_url().'assets/'.$data['url'].$data['example'] ?>" class="btn btn-danger pull-right" target="_blank">Open in New Tab</a>
			</div>
		</div>
	</div>
</div>