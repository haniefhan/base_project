<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
			</div>
			<div class="box-body">
				<?php 
					$url = base_url_admin().'profile/update';
				?>
				<form role="form" class="form form-horizontal" action="<?php echo $url ?>" method="POST">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="username">Username *</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="username" name="username" required="required" value="<?php echo isset($datas['username'])? $datas['username'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="email">Email *</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="email" class="form-control" id="email" name="email" required="required" value="<?php echo isset($datas['email'])? $datas['email'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="name">Full Name *</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="text" class="form-control" id="name" name="name" required="required" value="<?php echo isset($datas['name'])? $datas['name'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="old_password">Old Password</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Insert Old Password to change Password">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="password">New Password</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="password" class="form-control" id="password" name="password"  placeholder="New Password">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="repassword">Repeat New Password</label>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Repeat New Password">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12" for="role">&nbsp;</label>
						<div class="col-lg-8 col-md-2 col-sm-8 col-xs-12">
							<input type="submit" class="btn btn-primary form-control" value="Save Profile">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>