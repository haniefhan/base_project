<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $title; ?></div>
			<div class="panel-body">
				<?php 
				$first_half = true;
				if(!isset($datas)){
					$url = base_url_admin().$controller.'/insert';
				}else{
					// $url = base_url_admin().$controller.'/update?'.$primary_key.'='.$id;
					$url = base_url_admin().$controller.'/update?id='.$id;
				}
				?>
				<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST">
					<?php foreach ($table_field as $field => $tf) {?>
						<?php if($tf['in_form'] == true){ ?>
							<?php
								$label_width = 'col-lg-2 col-md-3 col-sm-3 col-xs-12';
								$input_width = 'col-lg-8 col-md-8 col-sm-8 col-xs-12';
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
									<?php }elseif($tf['type'] == 'select' or $tf['type'] == 'select-year'){ ?>
										<?php $select_value = isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value']; ?>
										<select class="form-control autocomplete" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?>>
											<!-- <option value=''>- Select <?php echo $tf['table_index'] ?> -</option> -->
											<?php foreach ($tf['value'] as $index => $value) {?>
												<?php $sel = ''; if($index == $select_value) $sel = 'selected="selected"'; ?>
												<option value="<?php echo $index ?>" <?php echo $sel ?>><?php echo $value ?></option>
											<?php } ?>
										</select>
									<?php }elseif($tf['type'] == 'textarea'){ ?>
										<textarea class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?>><?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?></textarea>
									<?php }elseif($tf['type'] == 'email'){ ?>
										<input type="email" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>"  <?php if($tf['required']){ ?> required="required" <?php } ?> <?php if(isset($tf['maxlength'])){ ?> maxlength="<?php echo $tf['maxlength']; ?>" <?php }else{ ?>maxlength="255"<?php } ?> placeholder="<?php echo $tf['name'] ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,3}$" title="Masukan format email dengan benar" />
									<?php }elseif($tf['type'] == 'date'){ ?>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control date" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
										</div>
									<?php }elseif($tf['type'] == 'datepicker'){ ?>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control date" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>" <?php if($tf['required']){ ?> required="required" <?php } ?> />
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
											<br/>
											<center><img src="<?php echo $this->securefile->open_file($datas[$tf['table_index']], true); ?>" style="<?php echo $tf['style'] ?>"></center>
											<br/>
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
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="role">&nbsp;</label>
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
							<input type="submit" class="btn btn-primary form-control" value="Save">
						</div>
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
							<a href="<?= base_url_admin().$controller;?>" class="btn btn-default form-control">Back</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>