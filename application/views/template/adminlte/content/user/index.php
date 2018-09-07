
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
				<a href="<?php echo base_url_admin().'user/add' ?>" class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Tambah User</a>
				<!-- <div class="clearfix"></div> -->
			</div>
			<div class="box-body table-responsive">
				<table class="table table-striped table-bordered table-hover datatable" id="tb-user" style="width: 100%">
					<thead>
						<th>No</th>
						<th>Username</th>
						<th>Name</th>
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