<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo asset_admin_url() ?>js/vendor/jquery.min.js"><\/script>')</script>
<script src="<?php echo asset_admin_url() ?>dist/js/bootstrap.min.js"></script>
<script src="<?php echo asset_admin_url() ?>js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo asset_admin_url() ?>js/ie10-viewport-bug-workaround.js"></script>

<?php
if($script != '' ){
	if (is_file(APPPATH.'views/'.$script.'.php')) $this->load->view($script);
}
?>