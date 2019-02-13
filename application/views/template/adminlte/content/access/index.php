<div class="row">
	<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
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
		<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
			<form role="form" class="form-horizontal" action="<?php echo base_url_admin() ?>access/update?id=<?php echo $id ?>" method="POST">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="box box-primary">
					<div class="box-header with-border"><h3 class="box-title">Set Access Right</h3></div>
					<div class="box-body">
						<!-- <div class="table-responsive"> -->
							<!-- <input type="submit" class="btn btn-primary pull-right" value="Save Access">
							<br/>
							<br/> -->
							<table class="table table-striped table-bordered table-hover" id="table-access">
								<thead>
									<tr>
										<!-- <th>#</th> -->
										<th style="width: 5%;">No</th>
										<th style="width: 210px;">Menu</th>
										<?php foreach ($access_name as $access) {?>
											<th class="text-center"><?php echo ucfirst(str_replace('_', ' ', $access)); ?></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php $no_all = 1; $no = 1; foreach ($menus as $i => $menu) {?>
										<?php 
											$access_manage = json_decode($menu['access_manage'], true);
											if(!is_array($access_manage)) $access_manage = array();
										?>
										<tr>
											<td><?php echo $no; $no++; ?>.</td>
											<td><?php echo $menu['name'] ?> <input type="checkbox" class="verticalCheck childCheck pull-right" id="<?php echo $i; ?>" title="Select All Right and Child"></td>
											<?php foreach ($access_name as $access) {?>
												<td class="text-center">
													<?php if(in_array($access, $access_manage)){ ?>
														<?php $sel = ''; if(isset($datas[$menu['id']][$access])){ if($datas[$menu['id']][$access] == 1) $sel = 'checked'; } ?>
														<input type="checkbox" name="menus[<?php echo $menu['id']; ?>][]" value="<?php echo $access ?>" <?php echo $sel ?>>
													<?php } ?>
												</td>
											<?php } ?>
										</tr>
										<?php if(isset($menu['children'])){ ?>
											<?php foreach ($menu['children'] as $j => $menu2) {?>
												<?php 
													$access_manage = json_decode($menu2['access_manage'], true);
													if(!is_array($access_manage)) $access_manage = array();
												?>
												<tr>
													<td></td>
													<td>-- <?php echo $menu2['name']; ?> <input type="checkbox" class="verticalCheck childCheck pull-right child-<?php echo $i ?>" id="<?php echo $i.'.'.$j; ?>" title="Select All Right and Child"></td>
													<?php foreach ($access_name as $access) { ?>
														<td class="text-center">
															<?php if(in_array($access, $access_manage)){ ?>
																<?php $sel = ''; if(isset($datas[$menu2['id']][$access])){ if($datas[$menu2['id']][$access] == 1) $sel = 'checked'; } ?>
																<input type="checkbox" class="child-<?php echo $i ?> child-<?php echo $i.'.'.$j; ?>" name="menus[<?php echo $menu2['id'] ?>][]" value="<?php echo $access ?>" <?php echo $sel ?>>
															<?php } ?>
														</td>
													<?php } ?>
												</tr>
												<?php foreach ($menu2['children'] as $k => $menu3) {?>
													<?php 
														$access_manage = json_decode($menu3['access_manage'], true);
														if(!is_array($access_manage)) $access_manage = array();
													?>
													<tr>
														<td></td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;-- <?php echo $menu3['name']; ?> <input type="checkbox" class="verticalCheck childCheck pull-right" id="<?php echo $i.'.'.$j.'.'.$k; ?>" title="Select All Right and Child child-<?php echo $i.'.'.$j; ?>"></td>
														<?php foreach ($access_name as $access) { ?>
															<td class="text-center">
																<?php if(in_array($access, $access_manage)){ ?>
																	<?php $sel = ''; if(isset($datas[$menu3['id']][$access])){ if($datas[$menu3['id']][$access] == 1) $sel = 'checked'; } ?>
																	<input type="checkbox" class="child-<?php echo $i ?> child-<?php echo $i.'.'.$j ?> child-<?php echo $i.'.'.$j.'.'.$k; ?>" name="menus[<?php echo $menu3['id'] ?>][]" value="<?php echo $access ?>" <?php echo $sel ?>>
																<?php } ?>
															</td>
														<?php } ?>
													</tr>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</tbody>
								<!-- <tfoot>
									<tr>
										<th style="width: 5%;">No</th>
										<th>Menu</th>
										<?php foreach ($access_name as $access) {?>
											<th style="width: 5%;" class="text-center"><?php echo ucfirst(str_replace('_', ' ', $access)); ?></th>
										<?php } ?>
									</tr>
								</tfoot> -->
							</table>
							<br/>
							<input type="submit" class="btn btn-primary pull-right" value="Save Access">
						<!-- </div> -->
					</div>
					<div class="overlay">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
				</div>
			</form>
		</div>
	<?php } ?>
</div>