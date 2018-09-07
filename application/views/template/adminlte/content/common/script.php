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
	</style>
<?php } ?>