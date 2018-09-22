<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">General Information</h3>
			</div>
			<div class="box-body">
				<form class="form-horizontal" role="form" action="<?php echo base_url_admin().'general/update' ?>" method="POST">
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="site_title">Site Title</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<input type="text" class="form-control" id="site_title" name="site_title" required="required" value="<?php echo isset($datas['site_title'])? $datas['site_title'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="tagline">Tagline</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<input type="text" class="form-control" id="tagline" name="tagline" value="<?php echo isset($datas['tagline'])? $datas['tagline'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="email">Email</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<input type="email" class="form-control" id="email" name="email" required="required" value="<?php echo isset($datas['email'])? $datas['email'] : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="time_zone">Time Zone</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<?php $sel_time_zone = isset($datas['time_zone'])? $datas['time_zone'] : ''; ?>
							<select id="time_zone" name="time_zone" class="form-control">
								<?php foreach ($timezones as $optgroup => $time) {?>
									<optgroup label="<?php echo $optgroup ?>"></optgroup>
									<?php foreach ($time as $tm) {?>
										<?php $sel = ''; if($tm[0] == $sel_time_zone){ $sel = 'selected="selected"'; } ?>
										<option value="<?php echo $tm[0] ?>" <?php echo $sel; ?>><?php echo $tm[1] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2" for="lang">Language</label>
						<?php $sel_lang = isset($datas['lang'])? $datas['lang'] : ''; ?>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<select id="lang" name="lang" class="form-control" disabled="disabled">
								<option value="english">Indonesia</option>
								<!-- <option value="id">Indonesia</option> -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-2">&nbsp;</label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<button type="submit" class="btn btn-primary form-control">Save Setting</button>	
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Site Logo</h3>
			</div>
			<div class="box-body">
				<form action="<?php echo base_url_admin().'general/update?state=logo' ?>" method="POST" enctype="multipart/form-data">
					<?php if(!isset($datas['logo'])){ ?>
					<div class="placeholder">
						<div class="inner">
							<span>No image selected</span>
						</div>
					</div>
					<?php }else{ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<center>
							<img src="<?php echo $datas['logo'] ?>"><br/><br/>
						</center>
					</div>
					<?php } ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><center><span>File width x height maximum : 250px x 85px</span></center></div>
					<div class="fileUpload btn btn-default col-lg-8 col-md-7 col-sm-7 col-xs-8">
						<span>Change Image</span>
						<input type="file" class="upload" name="logo">
					</div>
					<button type="submit" class="btn btn-primary fileUpload col-lg-3 col-md-4 col-sm-4 col-xs-3">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
.fileUpload {
	position: relative;
	overflow: hidden;
	margin: 5px;
}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
</style>