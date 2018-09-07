<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $title; ?></h3>
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
		</div>
	</div>
</div>