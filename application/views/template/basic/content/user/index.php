<!-- Notification -->
<?php $this->load->view($this->session->userdata('template_admin_use').'notification'); ?>
<!-- #Notification -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?>
				<a href="<?php echo base_url_admin().'user/add' ?>" class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Add <?php echo $title ?></a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover datatable" id="tb-user">
					<thead>
						<th>No</th>
						<th>Username</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Action</th>
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
	</div>
</div>