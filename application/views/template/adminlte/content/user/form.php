<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
			</div>
			<div class="box-body">
				<?php 
				if(!isset($datas)){
					$url = base_url_admin().'user/insert';
				}else{
					$url = base_url_admin().'user/update?id='.$id;
				}
				?>
				<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST">
					<div class="form-group">
						<label class="control-label col-sm-2" for="username">Username</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="username" name="username" required="required" value="<?php echo isset($datas['username'])? $datas['username'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Email</label>
						<div class="col-md-8 col-sm-10 col-xs-12">
							<input type="email" class="form-control" id="email" name="email" required="required" value="<?php echo isset($datas['email'])? $datas['email'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="name">Full Name</label>
						<div class="col-md-8 col-sm-10 col-xs-12">
							<input type="text" class="form-control" id="name" name="name" required="required" value="<?php echo isset($datas['name'])? $datas['name'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="password">Password</label>
						<div class="col-md-8 col-sm-10 col-xs-12">
							<input type="password" class="form-control" id="password" name="password" <?php if(!isset($datas)){ echo 'required="required"';} ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="repassword">Repeat Password</label>
						<div class="col-md-8 col-sm-10 col-xs-12">
							<input type="password" class="form-control" id="repassword" <?php if(!isset($datas)){ echo 'required="required"';} ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="role">Role</label>
						<div class="col-md-8 col-sm-10 col-xs-12">
							<select class="form-control" name="group_id">
								<?php foreach ($group as $i => $v) {?>
								<?php $sel = ''; if(isset($datas['group_id'])){ if($datas['group_id'] == $v['id']) $sel='selected="selected"';} ?>
								<option value="<?php echo $v['id'] ?>" <?php echo $sel ?>><?php echo $v['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="role">&nbsp;</label>
						<div class="col-md-2 col-sm-10 col-xs-12">
							<input type="submit" class="btn btn-primary form-control" value="Save User">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>