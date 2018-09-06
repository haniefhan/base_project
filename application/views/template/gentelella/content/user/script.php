<?php if(!isset($state)){ ?>
<!-- view -->
<script type="text/javascript">
	$(function(){
		$('body').delegate('.delete', 'click', function(event) {
			c = confirm('Delete this user?');
			if(!c){
				return false;
			}
		});

		table = $('#tb-user').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?php echo $datatable; ?>",
			"order": [[0, 'desc']],
			"pageLength": 25,
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td:eq(0)', nRow).html(table.page.info().start + iDisplayIndex + 1);//numbering
			}
		});
	})
</script>
<?php }elseif($state == 'add' or $state == 'edit'){ ?>
<!-- add, edit -->
<script type="text/javascript">
	$(function(){
		$('.form').submit(function(){
			if($('#password').val() != $('#repassword').val()){
				alert('Input Password and Repeat Password must be same!');
				return false;
			}
		})
	})
</script>
<?php } ?>