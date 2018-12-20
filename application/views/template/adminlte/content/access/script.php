<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo asset_admin_url() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script type="text/javascript">
	$(function(){
		$('.verticalCheck').click(function(){
			check = this.checked;
			$(this).parent().parent().find(':checkbox').prop('checked', check);
		})

		$('.childCheck').click(function(){
			check = this.checked;
			id 	  = $(this).attr('id');

			$(this).parent().parent().parent().find(':checkbox.child-'+id).prop('checked', check);
		})

		$('table#table-access').DataTable({
			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,
			paging : false,
			searching : false,
			ordering : false,
			bInfo : false,
			fixedColumns:   {
				leftColumns: 1,
			}
		});
	})
</script>