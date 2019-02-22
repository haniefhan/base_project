<?php if(!isset($state)){ ?>
<!-- view -->
<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script type="text/javascript">
	$(function(){
		$('body').delegate('.delete', 'click', function(event) {
			c = confirm('Delete this <?php echo $controller ?>?');
			if(!c){
				return false;
			}
		});

		function numberWithCommas(number) {
			if(number != null){
				var parts = number.toString().split(".");
				parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				return parts.join(",");
			}else{
				return number;
			}
		}

		table = $('#tb-<?php echo $controller ?>').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?php echo $datatable; ?>",
			"order": [[0, 'asc']],
			"pageLength": 25,
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				//numbering
				if(table.order()[0][0] == 0 && table.order()[0][1] == 'asc')
					$('td:eq(0)', nRow).html(table.page.info().start + iDisplayIndex + 1);
				else{
					info = table.page.info()
					$('td:eq(0)', nRow).html(info.recordsDisplay - iDisplayIndex - (info.page * info.length));
				}
				<?php $n = 0; foreach ($table_field as $i => $tf) {?>
					<?php 
						$in_table = true;
						if(isset($tf['in_table'])) $in_table = $tf['in_table'];
					?>
					<?php if($in_table == true){ ?>
						<?php if($tf['type'] == 'numeric'){ ?>
							$('td:eq(<?php echo $n; ?>)', nRow).html(numberWithCommas(aData[<?php echo $n ?>]));
							$('td:eq(<?php echo $n; ?>)', nRow).addClass('text-right');
						<?php }elseif($tf['type'] == 'money'){ ?>
							$('td:eq(<?php echo $n; ?>)', nRow).html('Rp. <span class="pull-right">'+numberWithCommas(aData[<?php echo $n ?>])+'</span>');
						<?php }elseif($tf['type'] == 'date' or $tf['type'] == 'datepicker'){ ?>
							if(aData[<?php echo $n ?>] != null){
								d = aData[<?php echo $n ?>].split('-');
								dd = d[2]+'/'+d[1]+'/'+d[0];
								$('td:eq(<?php echo $n; ?>)', nRow).html(dd);
							}
						<?php }elseif($tf['type'] == 'datetime'){ ?>
							if(aData[<?php echo $n ?>] != null){
								d = aData[<?php echo $n ?>].split(' ');
								dd = d[0].split('-');
								ddd = dd[2]+'/'+dd[1]+'/'+dd[0]+' '+d[1];
								$('td:eq(<?php echo $n; ?>)', nRow).html(ddd);
							}
						<?php } ?>
					<?php $n++; } ?>
				<?php } ?>
			},
			"aoColumns": [
				<?php $n = 0; foreach ($table_field as $tf) {?>
					<?php 
						$in_table = true;
						if(isset($tf['in_table'])) $in_table = $tf['in_table'];
					?>
					<?php if($in_table == true){ ?>
						{"bSearchable" : <?php echo ($tf['searchable'] == true) ? 'true' : 'false'; ?>, "bSortable": <?php echo ($tf['sortable'] == true) ? 'true' : 'false'; ?>}<?php if($n < count($table_field)) echo ', '; ?>
					<?php $n++; } ?>
				<?php } ?>
				// {"bSearchable" : false},
				// null,
				// {"bSearchable" : false, "bSortable": false}
			]
		});
		
		$('div.overlay').hide();

		$(window).on('beforeunload', function(){
			$('div.overlay').show();
		});
	})
</script>
<?php }elseif($state == 'add' or $state == 'edit'){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			// $("form input[type!='hidden']").eq(0).focus();
			$("form input:not(:disabled):not([readonly]):not([type='hidden'])").eq(0).focus();

			$('div.overlay').hide();

			$(window).on('beforeunload', function(){
				$('div.overlay').show();
			});
		})
	</script>
	<?php 
		$types = array();
		foreach ($table_field as $tf) {
			$types[$tf['type']] = $tf['type'];
		}
	?>
	<?php if(isset($types['select'])){ ?>
		<!-- select with select2 autocomplete -->
		<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/select2/dist/js/select2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/select2/dist/css/select2.min.css">
		<script type="text/javascript">
			$(document).ready(function(){
				$('.autocomplete').select2();
			})
		</script>
		<style type="text/css">
			.select2-container--default .select2-selection--single .select2-selection__arrow{
				height: 100%;
			}
			.select2-container{
				/**/
				height: 34px!important;
				width: 100%!important;
			}

			.select2-selection{
				height: 34px!important;
			}

			.select2-container--default .select2-selection--single{
				border:1px solid #ccc;
				border-radius:0px;
			}
		</style>
	<?php } ?>
	<!-- ## InputMask ## -->
	<?php if(isset($types['date']) or isset($types['numeric']) or isset($types['money']) or isset($types['year']) or isset($types['datetime'])){ ?>
		<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.js"></script>
		<script src="<?php echo asset_admin_url() ?>plugins/input-mask/jquery.inputmask.js"></script>
		<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.extensions.js"></script>
	<?php } ?>
	<?php if(isset($types['date']) or isset($types['year']) or isset($types['datetime'])){ ?>
		<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.date.extensions.js"></script>
	<?php } ?>
	<?php if(isset($types['date'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.datemask').inputmask("datetime", {inputFormat:'dd/mm/yyyy'});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['datetime'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.datetime').inputmask("datetime", {inputFormat:'dd/mm/yyyy HH:MM:ss'});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['year'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.yearmask').inputmask("datetime", {inputFormat:'yyyy'});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['numeric']) or isset($types['money'])){ ?>
		<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.numeric.extensions.js"></script>
	<?php } ?>
	<?php if(isset($types['numeric'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.numeric').inputmask('numeric', {rightAlign: true, radixPoint: ',', groupSeparator: '.', prefix: '', digits:0, autoGroup:true});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['money'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.currency').inputmask('currency', {rightAlign: true, radixPoint: ',', groupSeparator: '.', prefix: '', digits: 0});
			})
		</script>
	<?php } ?>
	<!-- ## End of InputMask ## -->
	<?php if(isset($types['datepicker'])){ ?>
		<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<script src="<?php echo asset_admin_url() ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.datepicker').datepicker({
					format: 'dd/mm/yyyy',
				});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['ckeditor'])){ ?>
		<script src="<?php echo asset_admin_url() ?>bower_components/ckeditor/ckeditor.js"></script>
		<script>
			$(function () {
				// CKEDITOR.replace('editor1')
				CKEDITOR.replaceClass = 'ckeditor';
			})
		</script>
	<?php } ?>
<?php }elseif($state == 'js'){ ?>
<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script type="text/javascript">
	$(function(){

		function numberWithCommas(number) {
			if(number != null){
				var parts = number.toString().split(".");
				parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				return parts.join(",");
			}else{
				return number;
			}
		}

		table = $('#tb-<?php echo $controller ?>').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?php echo $datatable; ?>",
			"order": [[0, 'asc']],
			"pageLength": 25,
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				//numbering
				if(table.order()[0][0] == 0 && table.order()[0][1] == 'asc')
					$('td:eq(0)', nRow).html(table.page.info().start + iDisplayIndex + 1);
				else{
					info = table.page.info()
					$('td:eq(0)', nRow).html(info.recordsDisplay - iDisplayIndex - (info.page * info.length));
				}
				<?php $n = 0; foreach ($table_field as $i => $tf) {?>
					<?php 
						$in_table = true;
						if(isset($tf['in_table'])) $in_table = $tf['in_table'];
					?>
					<?php if($in_table == true){ ?>
						<?php if($tf['type'] == 'numeric'){ ?>
							$('td:eq(<?php echo $n; ?>)', nRow).html(numberWithCommas(aData[<?php echo $n ?>]));
							$('td:eq(<?php echo $n; ?>)', nRow).addClass('text-right');
						<?php }elseif($tf['type'] == 'money'){ ?>
							$('td:eq(<?php echo $n; ?>)', nRow).html('Rp. <span class="pull-right">'+numberWithCommas(aData[<?php echo $n ?>])+'</span>');
						<?php }elseif($tf['type'] == 'date' or $tf['type'] == 'datepicker'){ ?>
							if(aData[<?php echo $n ?>] != null){
								d = aData[<?php echo $n ?>].split('-');
								dd = d[2]+'/'+d[1]+'/'+d[0];
								$('td:eq(<?php echo $n; ?>)', nRow).html(dd);
							}
						<?php }elseif($tf['type'] == 'datetime'){ ?>
							if(aData[<?php echo $n ?>] != null){
								d = aData[<?php echo $n ?>].split(' ');
								dd = d[0].split('-');
								ddd = dd[2]+'/'+dd[1]+'/'+dd[0]+' '+d[1];
								$('td:eq(<?php echo $n; ?>)', nRow).html(ddd);
							}
						<?php } ?>
					<?php $n++; } ?>
				<?php } ?>
			},
			"aoColumns": [
				<?php $n = 0; foreach ($table_field as $tf) {?>
					<?php 
						$in_table = true;
						if(isset($tf['in_table'])) $in_table = $tf['in_table'];
					?>
					<?php if($in_table == true){ ?>
						{"bSearchable" : <?php echo ($tf['searchable'] == true) ? 'true' : 'false'; ?>, "bSortable": <?php echo ($tf['sortable'] == true) ? 'true' : 'false'; ?>}<?php if($n < count($table_field)) echo ', '; ?>
					<?php $n++; } ?>
				<?php } ?>
				// {"bSearchable" : false},
				// null,
				// {"bSearchable" : false, "bSortable": false}
			]
		});
		
		$('div.overlay').hide();

		$(window).on('beforeunload', function(){
			$('div.overlay').show();
		});

		var insert_url = "<?php echo base_url_admin().$controller.'/insert'; ?>";

		$('a.add').click(function(event) {
			$('div#modal-form').modal('toggle');
			$('div#modal-form form').attr('action', insert_url);
			$('div#modal-form form').trigger('reset');
			<?php $n = 0; foreach ($table_field as $i => $tf) {?>
				<?php 
					$in_table = true;
					if(isset($tf['in_table'])) $in_table = $tf['in_table'];
				?>
				<?php if($in_table == true){ ?>
					<?php if($tf['type'] == 'select' || $tf['type'] == 'select-simple' || $tf['type'] == 'select-year'){ ?>
						$("div#modal-form form #<?php echo $tf['table_index'] ?>").trigger('change');
					<?php } ?>
				<?php $n++; } ?>
			<?php } ?>
			event.preventDefault();
		});

		$('body').delegate('.edit', 'click', function(event) {
			url = $(this).attr('href');
			$('div#modal-form form').attr('action', url);

			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json',
			})
			.done(function(respond) {
				<?php $n = 0; foreach ($table_field as $i => $tf) {?>
					<?php 
						$in_table = true;
						if(isset($tf['in_table'])) $in_table = $tf['in_table'];
					?>
					<?php if($in_table == true){ ?>
						$("div#modal-form form #<?php echo $tf['table_index'] ?>").val(respond.<?php echo $tf['table_index'] ?>);
						<?php if($tf['type'] == 'select' || $tf['type'] == 'select-simple' || $tf['type'] == 'select-year'){ ?>
							$("div#modal-form form #<?php echo $tf['table_index'] ?>").trigger('change');
						<?php } ?>
					<?php $n++; } ?>
				<?php } ?>
				$('div#modal-form').modal('toggle');
			})
			.fail(function(respond) {
				$('div.overlay').hide();
				show_notification('false', 'System Error, please contact your administrator if this error persist.');
				$('div#modal-form').modal('toggle');
				table.ajax.reload();
			});

			event.preventDefault();
		});

		function show_notification(notif_status, notif_msg){
			ntf = 'danger';
			if(notif_status == 'true'){
				ntf = 'success';
			}
			html = '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="alert alert-'+ntf+' text-center alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5 style="margin: 0">'+notif_msg+'</h5></div></div></div>';
			$('section.content').prepend(html)
		}

		$('div#modal-form form').submit(function(event) {
			$('div.overlay').show();
			url  = $(this).attr('action');
			data = $(this).serialize();
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(respond) {
				$('div.overlay').hide();
				show_notification(respond.notif_status, respond.notif_msg);
				$('div#modal-form').modal('toggle');
				table.ajax.reload();
			})
			.fail(function(respond) {
				$('div.overlay').hide();
				show_notification('false', 'System Error, please contact your administrator if this error persist.');
				$('div#modal-form').modal('toggle');
				table.ajax.reload();
			});
			
			event.preventDefault();
		});

		$('body').delegate('.delete', 'click', function(event) {
			event.preventDefault();
			c = confirm('Delete this <?php echo $controller ?>?');
			if(c){
				$('div.overlay').show();
				url = $(this).attr('href');
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					data: data,
				})
				.done(function(respond) {
					$('div.overlay').hide();
					show_notification(respond.notif_status, respond.notif_msg);
					table.ajax.reload();
				})
				.fail(function(respond) {
					$('div.overlay').hide();
					show_notification('false', 'System Error, please contact your administrator if this error persist.');
					table.ajax.reload();
				});
			}
		});

		$('div#modal-form form #close').click(function(event) {
			$('div#modal-form').modal('toggle');
			event.preventDefault();
		});
	})
</script>
<?php 
	$types = array();
	foreach ($table_field as $tf) {
		$types[$tf['type']] = $tf['type'];
	}
?>
<?php if(isset($types['select'])){ ?>
	<!-- select with select2 autocomplete -->
	<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/select2/dist/js/select2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/select2/dist/css/select2.min.css">
	<script type="text/javascript">
		$(document).ready(function(){
			$('.autocomplete').select2();
		})
	</script>
	<style type="text/css">
		.select2-container--default .select2-selection--single .select2-selection__arrow{
			height: 100%;
		}
		.select2-container{
			/**/
			height: 34px!important;
			width: 100%!important;
		}

		.select2-selection{
			height: 34px!important;
		}

		.select2-container--default .select2-selection--single{
			border:1px solid #ccc;
			border-radius:0px;
		}
	</style>
<?php } ?>
<!-- ## InputMask ## -->
<?php if(isset($types['date']) or isset($types['numeric']) or isset($types['money']) or isset($types['year']) or isset($types['datetime'])){ ?>
	<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.js"></script>
	<script src="<?php echo asset_admin_url() ?>plugins/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.extensions.js"></script>
<?php } ?>
<?php if(isset($types['date']) or isset($types['year']) or isset($types['datetime'])){ ?>
	<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.date.extensions.js"></script>
<?php } ?>
<?php if(isset($types['date'])){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.datemask').inputmask("datetime", {inputFormat:'dd/mm/yyyy'});
		})
	</script>
<?php } ?>
<?php if(isset($types['datetime'])){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.datetime').inputmask("datetime", {inputFormat:'dd/mm/yyyy HH:MM:ss'});
		})
	</script>
<?php } ?>
<?php if(isset($types['year'])){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.yearmask').inputmask("datetime", {inputFormat:'yyyy'});
		})
	</script>
<?php } ?>
<?php if(isset($types['numeric']) or isset($types['money'])){ ?>
	<script src="<?php echo asset_admin_url() ?>plugins/input-mask/inputmask.numeric.extensions.js"></script>
<?php } ?>
<?php if(isset($types['numeric'])){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.numeric').inputmask('numeric', {rightAlign: true, radixPoint: ',', groupSeparator: '.', prefix: '', digits:0, autoGroup:true});
		})
	</script>
<?php } ?>
<?php if(isset($types['money'])){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.currency').inputmask('currency', {rightAlign: true, radixPoint: ',', groupSeparator: '.', prefix: '', digits: 0});
		})
	</script>
<?php } ?>
<!-- ## End of InputMask ## -->
<?php if(isset($types['datepicker'])){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<script src="<?php echo asset_admin_url() ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.datepicker').datepicker({
				format: 'dd/mm/yyyy',
			});
		})
	</script>
<?php } ?>
<?php if(isset($types['ckeditor'])){ ?>
	<script src="<?php echo asset_admin_url() ?>bower_components/ckeditor/ckeditor.js"></script>
	<script>
		$(function () {
			// CKEDITOR.replace('editor1')
			CKEDITOR.replaceClass = 'ckeditor';
		})
	</script>
<?php } ?>
<?php } ?>