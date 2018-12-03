<div class="row">
	<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-body">
				<form role="form" class="form-horizontal" action="<?php echo base_url_admin() ?>access/edit" method="GET">
					<div class="form-group">
						<label class="control-label col-lg-1 col-md-1 col-sm-2 col-xs-2" for="parent">Group</label>
						<div class="col-lg-7 col-md-7 col-sm-6 col-xs-6">
							<select class="form-control" name="id">
								<option value=""> --- </option>
								<?php foreach ($group as $i => $v) {?>
									<?php $sel = ''; if(isset($id)){ if($id == $v['id']) $sel = 'selected'; } ?>
									<option value="<?php echo $v['id'] ?>" <?php echo $sel ?>><?php echo $v['name'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
							<input type="submit" value="Show Access" class="btn btn-primary form-control">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Notification -->
	<?php // $this->load->view($this->session->userdata('template_admin_use').'notification'); ?>
	<!-- #Notification -->
	<?php if(isset($menus)){ ?>
		<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
			<form role="form" class="form-horizontal" action="<?php echo base_url_admin() ?>access/update?id=<?php echo $id ?>" method="POST">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="box box-primary">
					<div class="box-header with-border"><h3 class="box-title">Set Access Right</h3></div>
					<div class="box-body">
						<input type="submit" class="btn btn-primary pull-right" value="Save Access">
						<br/>
						<br/>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Menu</th>
									<?php foreach ($access_name as $access) {?>
										<th style="width: 10%;" class="text-center"><?php echo ucfirst($access); ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach ($menus as $i => $menu) {?>
									<tr>
										<td><?php echo $no; $no++; ?>.</td>
										<td><?php echo $menu['name'] ?> <input type="checkbox" class="verticalCheck childCheck pull-right" id="<?php echo $i ?>" title="Select All Right and Child"></td>
										<?php foreach ($access_name as $access) {?>
											<?php $sel = ''; if(isset($datas[$menu['id']])){ if($datas[$menu['id']][$access] == 1) $sel = 'checked'; } ?>
											<td class="text-center"><input type="checkbox" name="menus[<?php echo $menu['id'] ?>][<?php echo $access ?>]" value="1" <?php echo $sel ?>></td>
										<?php } ?>
									</tr>
									<?php if(isset($menu['children'])){ ?>
										<?php foreach ($menu['children'] as $j => $menu2) {?>
											<tr>
												<td></td>
												<td>-- <?php echo $menu2['name']; ?></td>
												<?php foreach ($access_name as $access) {?>
													<?php $sel = ''; if(isset($datas[$menu2['id']])){ if($datas[$menu2['id']][$access] == 1) $sel = 'checked'; } ?>
													<td class="text-center"><input class="child-<?php echo $i ?>" type="checkbox" name="menus[<?php echo $menu2['id'] ?>][<?php echo $access ?>]" value="1" <?php echo $sel ?>></td>
												<?php } ?>
											</tr>
											<?php foreach ($menu2['children'] as $j => $menu3) {?>
												<tr>
													<td></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;-- <?php echo $menu3['name']; ?></td>
													<?php foreach ($access_name as $access) {?>
														<?php $sel = ''; if(isset($datas[$menu3['id']])){ if($datas[$menu3['id']][$access] == 1) $sel = 'checked'; } ?>
														<td class="text-center"><input class="child-<?php echo $i ?>" type="checkbox" name="menus[<?php echo $menu3['id'] ?>][<?php echo $access ?>]" value="1" <?php echo $sel ?>></td>
													<?php } ?>
												</tr>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<input type="submit" class="btn btn-primary pull-right" value="Save Access">
					</div>
				</div>
			</form>
		</div>
	<?php } ?>
</div>