<div class="row">
	<!-- Notification -->
	<?php $this->load->view($this->session->userdata('template_admin_use').'notification'); ?>
	<!-- #Notification -->
	<?php 
		if(!isset($datas)){
			$url = base_url_admin().'user/insert';
		}else{
			$url = base_url_admin().'user/update?id='.$id;
		}
	?>
	<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST">
		<div class="col-lg-10">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo lang('User') ?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-sm-3" for="username"><?php echo lang('Username') ?></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="username" name="username" required="required" value="<?php echo isset($datas['username'])? $datas['username'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="email"><?php echo lang('Email') ?></label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="email" name="email" required="required" value="<?php echo isset($datas['email'])? $datas['email'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="name"><?php echo lang('Full Name') ?></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="name" name="name" required="required" value="<?php echo isset($datas['name'])? $datas['name'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="password"><?php echo lang('Password') ?></label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="password" name="password" <?php if(!isset($datas)){ echo 'required="required"';} ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="repassword"><?php echo lang('Repeat Password') ?></label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="repassword" <?php if(!isset($datas)){ echo 'required="required"';} ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="role"><?php echo lang('Role') ?></label>
						<div class="col-sm-8">
							<select class="form-control" name="group_id">
								<?php foreach ($group as $i => $v) {?>
									<?php $sel = ''; if(isset($datas['group_id'])){ if($datas['group_id'] == $v['id']) $sel='selected="selected"';} ?>
									<option value="<?php echo $v['id'] ?>" <?php echo $sel ?>><?php echo $v['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<input type="submit" class="btn btn-primary" value="<?php echo lang('Save') ?>">
				</div>
			</div>
		</div>
	</form>
</div>