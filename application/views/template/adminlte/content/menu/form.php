<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
			</div>
			<div class="box-body">
				<?php 
				$first_half = true;
				if(!isset($datas)){
					$url = base_url_admin().$controller.'/insert';
				}else{
					// $url = base_url_admin().$controller.'/update?'.$primary_key.'='.$id;
					$url = base_url_admin().$controller.'/update?id='.$id;
				}
				?>
				<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<?php foreach ($table_field as $i => $tf) {?>
							<?php if($tf['in_form'] == true){ ?>
								<?php
									$label_width = 'col-lg-2 col-md-3 col-sm-2 col-xs-12';
									$input_width = 'col-lg-10 col-md-9 col-sm-10 col-xs-12';
									$full_width = true;
									if(isset($tf['form-width'])){
										if($tf['form-width'] == 'half'){
											$label_width = 'col-lg-2 col-md-3 col-sm-3 col-xs-12';
											$input_width = 'col-lg-3 col-md-3 col-sm-8 col-xs-12';
											$full_width = false;
										}
									}

									// special for password
									if($state == 'edit' && $tf['type'] == 'password'){
										$tf['required'] = false;
									}
								?>

								<?php if($full_width == true or ($full_width == false and $first_half == true)){ ?><div class="form-group"><?php } ?>
									<label class="control-label <?php echo $label_width; ?>" for="<?php echo $tf['table_index'] ?>"><?php echo $tf['name'] ?> <?php if($tf['required']){ ?><span class="required">*</span><?php } ?></label>
									<div class="<?php echo $input_width; ?>">
										<?php if($tf['type'] == 'text'){ ?>
											<input type="text" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>"  <?php if($tf['required']){ ?> required="required" <?php } ?> <?php if(isset($tf['maxlength'])){ ?> maxlength="<?php echo $tf['maxlength']; ?>" <?php }else{ ?>maxlength="255"<?php } ?> placeholder="<?php echo $tf['name'] ?>" />
										<?php }elseif($tf['type'] == 'select' or $tf['type'] == 'select-year' or $tf['type'] == 'select-simple'){ ?>
											<?php $select_value = isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value']; ?>
											<select class="form-control autocomplete" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?>>
												<option value=''>- Select <?php echo $tf['name'] ?> -</option>
												<?php foreach ($tf['value'] as $index => $value) {?>
													<?php $sel = ''; if($index == $select_value) $sel = 'selected="selected"'; ?>
													<option value="<?php echo $index ?>" <?php echo $sel ?>><?php echo $value ?></option>
												<?php } ?>
											</select>
										<?php }elseif($tf['type'] == 'textarea'){ ?>
											<textarea class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?>><?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?></textarea>
										<?php }elseif($tf['type'] == 'ckeditor'){ ?>
											<textarea class="form-control ckeditor" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?>><?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?></textarea>
										<?php }elseif($tf['type'] == 'email'){ ?>
											<input type="email" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>"  <?php if($tf['required']){ ?> required="required" <?php } ?> <?php if(isset($tf['maxlength'])){ ?> maxlength="<?php echo $tf['maxlength']; ?>" <?php }else{ ?>maxlength="255"<?php } ?> placeholder="<?php echo $tf['name'] ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,3}$" title="Masukan format email dengan benar" />
										<?php }elseif($tf['type'] == 'date'){ ?>
											<div class="input-group">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control datemask" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
											</div>
										<?php }elseif($tf['type'] == 'datetime'){ ?>
											<div class="input-group">
												<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
												<input type="text" class="form-control datetime" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
											</div>
										<?php }elseif($tf['type'] == 'datepicker'){ ?>
											<div class="input-group">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control datepicker" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
											</div>
										<?php }elseif($tf['type'] == 'numeric'){ ?>
											<input type="text" class="form-control numeric" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
										<?php }elseif($tf['type'] == 'money'){ ?>
											<div class="input-group">
												<div class="input-group-addon">Rp.</div>
												<input type="text" class="form-control currency" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
												<div class="input-group-addon">,00</div>
											</div>
										<?php }elseif($tf['type'] == 'year'){ ?>
											<input type="text" class="form-control yearmask" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
										<?php }elseif($tf['type'] == 'file'){ ?>
											<input type="file" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
											<?php if(isset($datas[$tf['table_index']])){ ?>
												<?php 
													$img = '';
													if($this->securefile->open_file($datas[$tf['table_index']], true) != '')  $img = $this->securefile->open_file($datas[$tf['table_index']], true);
												?>
												<?php if($img != ''){ ?>
													<br/>
													<center><img src="<?php echo $img; ?>" style="<?php echo $tf['style'] ?>"></center>
													<br/>
												<?php } ?>
											<?php } ?>
										<?php }elseif($tf['type'] == 'password'){ ?>
											<input type="password" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> <?php if(isset($tf['maxlength'])){ ?> maxlength="<?php echo $tf['maxlength']; ?>" <?php }else{ ?>maxlength="255"<?php } ?> placeholder="<?php echo $tf['name'] ?>" />
										<?php } ?>
									</div>
									<?php 
										$if_half_case = false;
										// $next_width_half = false;
										// if(isset($tf[$i+1]['form-width'])){
										// 	if($tf[$i+1]['form-width'] == 'half') $next_width_half = true;
										// }

										if($full_width == false and $first_half == false){
											$if_half_case = true;
										}
									?>
								<?php if($full_width == true or $if_half_case == true){ ?></div><?php } ?>
								<?php
									if(isset($tf['form-width'])){
										if($tf['form-width'] == 'half'){
											if($first_half == true) $first_half = false;
											else $first_half = true;
										}
									}
								?>
							<?php } ?>
						<?php } ?>
					</div>
					<?php
						$access_manage = isset($datas['access_manage']) ? json_decode($datas['access_manage'], true) : array();
						if(!is_array($access_manage)) $access_manage = array();
					?>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<table class="table table-bordered">
							<thead>
								<th>No</th>
								<th>Function Name</th>
								<th>Can Access?</th>
							</thead>
							<tbody>
								<?php $no = 1; foreach ($basic_access as $acc) { ?>
									<?php 
										$sel = '';
										if(in_array($acc, $access_manage)){
											$sel = 'checked';
											unset($access_manage[array_search($acc, $access_manage)]);
										}
									?>
									<tr>
										<td style="width: 30px;" class="text-right"><?php echo $no; ?></td>
										<td><?php echo $acc; ?></td>
										<td><input type="checkbox" name="basic_access[]" value="<?php echo $acc; ?>" <?php echo $sel; ?>></td>
									</tr>
								<?php $no++; } ?>
								<?php for ($i = 0; $i < 5; $i++) { ?>
									<?php 
										$accs = array_pop($access_manage);
										$value = '';
										$sel = '';
										if($accs != NULL){
											$value = $accs;
											$sel = 'checked';
										}
									?>
									<tr>
										<td style="width: 30px;" class="text-right"><?php echo $no; ?></td>
										<td><input type="text" name="add_access[]" style="width: 100%" placeholder="Function name in controller" value="<?php echo $value; ?>"></td>
										<td><input type="checkbox" name="add_manage[]" <?php echo $sel; ?>></td>
									</tr>
								<?php $no++; } ?>
							</tbody>
						</table>
					</div>
					<div class="col-lg-offset-3 col-lg-12">
						<div class="form-group">
							<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
								<input type="submit" class="btn btn-primary form-control" value="Save">
							</div>
							<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
								<a href="<?= base_url_admin().$controller;?>" class="btn btn-default form-control">Back</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>