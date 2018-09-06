<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">Dashboard</div>
			<div class="panel-body">
				<center>
					<a href="<?php echo base_url().'index.php/dashboard/update_all' ?>" class="btn btn-primary"><i class="fa fa-refresh"></i>Update All</a>
				</center>
				<table class="table table-bordered" id="tb-dashboard">
					<thead>
						<th>No</th>
						<th>Title</th><!-- style="width: 35%;" -->
						<th style="width: 50px;">Read Status</th><!-- style="width: 8%;" -->
						<th>Website</th>
						<th>Updated</th>
						<th style="width:230px;">Action</th>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($novels as $novel) {?>
							<tr>
								<td><?php echo $no ?></td>
								<td>
									<a href="<?php echo base_url().'index.php/novel/read?novel_id='.$novel['nv_id'].'&chp='.$novel['last_chapter'].'#'.$novel['last_chapter'] ?>" target="_blank">
										<?php echo $novel['nv_name'] ?>
										<?php
											if($novel['last_chapter'] == 1){
												$btn_type = 'btn-default';
											}elseif($novel['last_chapter'] < $novel['nv_chapter']){
												$btn_type = 'btn-danger';
											}elseif($novel['last_chapter'] >= $novel['nv_chapter']){
												$btn_type = 'btn-success'; 
											}
										?>
										<span class="btn <?php echo $btn_type; ?> btn-xs pull-right"><i class="fa fa-book"></i></span>
									</a>
								</td>
								<td class="text-center">
									<a href="<?php echo base_url().'index.php/novel/read?novel_id='.$novel['nv_id'].'&chp='.$novel['last_chapter'].'#'.$novel['last_chapter'] ?>" target="_blank"><?php echo str_pad($novel['last_chapter'], 4, "0", STR_PAD_LEFT); ?></a> | 
									<a href="<?php echo base_url().'index.php/novel/read?novel_id='.$novel['nv_id'].'&chp='.$novel['nv_chapter'].'#'.$novel['nv_chapter']; ?>" target="_blank"><?php echo str_pad($novel['nv_chapter'], 4, '0', STR_PAD_LEFT) ?></a>
								</td>
								<td><?php echo $novel['web_name']; ?></td>
								<td><?php echo ($novel['updated']) ? '<a href="#" style="width:100%" class="btn btn-success btn-xs">Updated</a>' : ''; ?></td>
								<td>
									<a href="<?php echo base_url().'index.php/dashboard/download_all_chapter/'.$novel['nv_id']; ?>" class="btn btn-primary btn-xs download_new_chapter"><i class="fa fa-download"></i> Download New Chapter</a>
									<a href="<?php echo $novel['nv_url'] ?>" target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-link"> Go To Site</i></a>
								</td>
							</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>