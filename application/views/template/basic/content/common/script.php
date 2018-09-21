<?php if(!isset($state)){ ?>
<!-- view -->
<script type="text/javascript" src="<?php echo asset_admin_url() ?>dist/datatables.net/js/jquery.datatables.js"></script>
<script type="text/javascript" src="<?php echo asset_admin_url() ?>dist/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>css/datatables.css">
<script type="text/javascript">
	$(function(){
		$('body').delegate('.delete', 'click', function(event) {
			c = confirm('Delete this <?php echo $controller ?>?');
			if(!c){
				return false;
			}
		});

		function numberWithCommas(number) {
		    var parts = number.toString().split(".");
		    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		    return parts.join(",");
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
							$('td:eq(<?php echo $n; ?>)', nRow).html('Rp. <span class="pull-right">'+numberWithCommas(aData[<?php echo $i ?>])+'</span>');
						<?php }elseif($tf['type'] == 'date' or $tf['type'] == 'datepicker'){ ?>
							d = aData[<?php echo $n ?>].split('-');
							dd = d[2]+'/'+d[1]+'/'+d[0];
							$('td:eq(<?php echo $n; ?>)', nRow).html(dd);
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
	<?php if(isset($types['datepicker']) or isset($types['date'])){ ?>
		<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>dist/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker.css">
		<script src="<?php echo asset_admin_url() ?>dist/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input.date').datepicker({
					format: 'dd/mm/yyyy'
				});
			})
		</script>
	<?php } ?>
<?php } ?>