<?php if(!isset($state)){ ?>
<!-- view -->
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

		order = [0, 'asc'];
		<?php if(isset($dt_order)){ ?>
			order = [<?php echo $dt_order[0] ?>, "<?php echo $dt_order[1]; ?>"];
		<?php } ?>

		table = $('#tb-<?php echo $controller ?>').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?php echo $datatable; ?>",
			"order": [order],
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
							$('td:eq(<?php echo $n; ?>)', nRow).html('Rp. <span class="pull-right">'+numberWithCommas(aData[<?php echo $i ?>])+'</span>');
						<?php }elseif($tf['type'] == 'date' or $tf['type'] == 'datepicker'){ ?>
							d = aData[<?php echo $n ?>].split('-');
							dd = d[2]+'/'+d[1]+'/'+d[0];
							$('td:eq(<?php echo $n; ?>)', nRow).html(dd);
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
						{"bSearchable" : <?php echo (int)$tf['searchable'] ?>, "bSortable": <?php echo (int)$tf['sortable'] ?>}<?php if($n < count($table_field)) echo ', '; ?>
					<?php $n++; } ?>
				<?php } ?>
				// {"bSearchable" : false},
				// null,
				// {"bSearchable" : false, "bSortable": false}
			]
		});
	})
</script>
<?php }elseif($state == 'add' or $state == 'edit'){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('form input').eq(0).focus();
		})
	</script>
	<?php 
		$types = array();
		foreach ($table_field as $tf) {
			$types[$tf['type']] = $tf['type'];
		}
	?>
	<?php if(isset($types['select']) or isset($types['select-simple']) or isset($types['select-year'])){ ?>
		<!-- select with select2 autocomplete -->
		<script type="text/javascript" src="<?php echo asset_admin_url() ?>vendors/select2/dist/js/select2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>vendors/select2/dist/css/select2.min.css">
		<script type="text/javascript">
			$(document).ready(function(){
				$('.autocomplete').select2();
			})
		</script>
		<style type="text/css">
			.select2-container--default .select2-selection--single .select2-selection__arrow{
				height: 100%;
			}
			.select2-container .select2-selection--single{
				width: 100%;
			}
		</style>
	<?php } ?>
	<!-- ## InputMask ## -->
	<?php if(isset($types['date']) or isset($types['numeric']) or isset($types['money']) or isset($types['year']) or isset($types['datetime'])){ ?>
		<script src="<?php echo asset_admin_url() ?>vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
	<?php } ?>
	<?php if(isset($types['date'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.datemask').inputmask("date");
			})
		</script>
	<?php } ?>
	<?php if(isset($types['datetime'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.datetime').inputmask("datetime");
			})
		</script>
	<?php } ?>
	<?php if(isset($types['year'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.yearmask').inputmask("9999", {placeholder:'yyyy'});
			})
		</script>
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
		<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css">
		<script src="<?php echo asset_admin_url() ?>vendors/moment/min/moment.min.js"></script>
		<script src="<?php echo asset_admin_url() ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.daterangepicker').datetimepicker({
					format: 'DD/MM/YYYY'
				});
			})
		</script>
	<?php } ?>
	<?php if(isset($types['ckeditor'])){ ?>
		<!-- <script src="<?php echo asset_admin_url() ?>vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
		<link href="<?php echo asset_admin_url() ?>vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
		<script>
			$(function () {
				$('.ckeditor').wysiwyg();
			})
		</script> -->
	<?php } ?>
<?php } ?>