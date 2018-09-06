<!-- Notification -->
<?php $this->load->view($this->session->userdata('template_admin_use').'notification'); ?>
<!-- #Notification -->
<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered table-hover datatable" id="tb-user">
			<thead>
				<th><?php echo lang('No') ?></th>
				<th><?php echo lang('Username') ?></th>
				<th><?php echo lang('Full Name') ?></th>
				<th><?php echo lang('Email') ?></th>
				<th><?php echo lang('Role') ?></th>
				<th><?php echo lang('Action') ?></th>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach ($datas as $i => $data) {?>
					<tr>
						<td><?php echo $no; $no++; ?></td>
						<td><?php echo $data['username'] ?></td>
						<td><?php echo $data['name'] ?></td>
						<td><?php echo $data['email'] ?></td>
						<td><?php echo $data['group_name'] ?></td>
						<td>
							<?php echo button_access('edit', uri_string(), $data['id']); ?>
							<?php echo button_access('delete', uri_string(), $data['id']); ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>