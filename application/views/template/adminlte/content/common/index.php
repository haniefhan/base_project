<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
				<?php if(check_access_menu(uri_string().'/print_excel')){ ?>
					<a href="<?php echo base_url_admin().$controller.'/print_excel' ?>" class="btn btn-primary pull-right btn-sm"><i class="fa fa-print"></i> Print <?php echo $title ?></a>
				<?php } ?>
				<?php if(check_access_menu(uri_string().'/upload_csv')){ ?>
					<a href="#" class="btn btn-warning pull-right btn-sm" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-file-excel-o"></i> Upload CSV</a>
				<?php } ?>
				<?php if(check_access_menu(uri_string().'/upload_excel')){ ?>
					<a href="#" class="btn btn-warning pull-right btn-sm" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-file-excel-o"></i> Upload Excel</a>
				<?php } ?>
				<a href="<?php echo base_url_admin().$controller.'/add' ?>" class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Add <?php echo $title ?></a>
				<!-- <div class="clearfix"></div> -->
			</div>
			<div class="box-body table-responsive">
				<table class="table table-striped table-bordered table-hover datatable" id="tb-<?php echo $controller ?>"  style="width: 100%">
					<thead>
						<?php foreach ($table_field as $index => $tf) {?>
							<?php 
								$in_table = true;
								if(isset($tf['in_table'])) $in_table = $tf['in_table'];
							?>
							<?php if($in_table == true){ ?>
								<th style="<?php echo $tf['style'] ?>"><?php echo $tf['name'] ?></th>
							<?php } ?>
						<?php } ?>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="overlay">
				<i class="fa fa-spinner fa-spin"></i>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	div.box-header.with-border a{
		margin: 0px 2px;
	}
</style>
<?php if(check_access_menu(uri_string().'/upload_csv')){ ?>
	<div class="modal fade" id="modal-upload">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Upload CSV</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url_admin().$controller.'/upload_csv?type=upload'; ?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								Upload CSV :
							</div>
							<div class="col-xs-8 col-lg-8">
								<input type="file" name="file" class="form-control"><br/><label><input type="checkbox" name="reset_all" value="true"> Perbaharui semua data</label>
							</div>
							<div class="col-xs-4 col-lg-4">
								<input type="submit" value="Submit CSV" class="btn btn-primary form-control">
							</div>
							<div class="col-xs-12 col-lg-12">
								<br/>Download Format CSV disini :&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url_admin().$controller.'/upload_csv?type=format'; ?>" class="btn btn-warning btn-xs" style="padding-left:20px;padding-right: 20px;"><i class="fa fa-file-excel-o"></i> Format CSV</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if(check_access_menu(uri_string().'/upload_excel')){ ?>
	<div class="modal fade" id="modal-upload">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Upload Excel</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url_admin().$controller.'/upload_excel?type=upload'; ?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								Upload Excel :
							</div>
							<div class="col-xs-8 col-lg-8">
								<input type="file" name="file" class="form-control"><br/><label><input type="checkbox" name="reset_all" value="true"> Perbaharui semua data</label>
							</div>
							<div class="col-xs-4 col-lg-4">
								<input type="submit" value="Submit Excel" class="btn btn-primary form-control">
							</div>
							<div class="col-xs-12 col-lg-12">
								<br/>Download Format Excel disini :&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url_admin().$controller.'/upload_excel?type=format'; ?>" class="btn btn-warning btn-xs" style="padding-left:20px;padding-right: 20px;"><i class="fa fa-file-excel-o"></i> Format Excel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>