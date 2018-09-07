<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $title; ?></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?php 
				if(!isset($datas)){
					$url = base_url_admin().$controller.'/insert';
				}else{
					$url = base_url_admin().$controller.'/update?'.$primary_key.'='.$id;
				}
				?>
				<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST">
					<?php foreach ($table_field as $field => $tf) {?>
						<?php if($tf['in_form'] == true){ ?>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="<?php echo $tf['table_index'] ?>"><?php echo $tf['name'] ?> <?php if($tf['required']){ ?><span class="required">*</span><?php } ?></label>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-10">
									<?php if($tf['type'] == 'text'){ ?>
										<input type="text" class="form-control" id="<?php echo $tf['table_index'] ?>" name="<?php echo $tf['table_index'] ?>" value="<?php echo isset($datas[$tf['table_index']])? $datas[$tf['table_index']] : $tf['value'] ?>"  <?php if($tf['required']){ ?> required="required" <?php } ?>/>
									<?php }elseif($tf['type'] == 'select'){ ?>
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
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-2" for="role">&nbsp;</label>
						<div class="col-lg-2 col-md-4 col-sm-4 col-xs-5">
							<input type="submit" class="btn btn-primary form-control" value="Save <?php echo ucfirst($controller) ?>">
						</div>
						<div class="col-lg-2 col-md-4 col-sm-4 col-xs-5">
							<a href="<?= base_url_admin().$controller;?>" class="btn btn-default form-control">Back</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>