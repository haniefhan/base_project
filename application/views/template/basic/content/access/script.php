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
	})
</script>