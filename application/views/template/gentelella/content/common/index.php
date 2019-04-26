<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $title; ?></h2>
				<?php if(check_access_menu(uri_string().'/print_excel')){ ?>
					<a href="<?php echo base_url_admin().$controller.'/print_excel' ?>" class="btn btn-primary pull-right btn-sm"><i class="fa fa-print"></i> Print <?php echo $title ?></a>
				<?php } ?>
				<?php if(check_access_menu(uri_string().'/add')){ ?>
					<a href="<?php echo base_url_admin().$controller.'/add' ?>" class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Add <?php echo $title ?></a>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table table-striped table-bordered table-hover datatable" id="tb-<?php echo $controller ?>">
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
<style type="text/css">
	div.box-header.with-border a{
		margin: 0px 2px;
	}
</style>