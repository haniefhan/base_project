<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $this->session->userdata('site_title').' | '.$title; ?></title>
		<!-- Bootstrap -->
		<link href="<?php echo asset_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo asset_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo asset_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo asset_url(); ?>build/css/custom.min.css" rel="stylesheet">
		<style type="text/css">
			.nav-md .container.body .right_col {
				margin-left: 0;
			}
			.nav-sm .container.body .right_col {
				margin-left: 0;
			}
			footer {
				border-top: 1px solid #d2d6de;
			}
			@media (min-width: 992px){
				footer {
				margin-left: 0px;
				}
			}
			.nav-sm footer {
				margin-left: 0px;
			}
			/*.nav_menu {
			    background: #2A3F54;
			    border-bottom: 3px solid #009688;
			}*/
			.navbar-static-top {
			    background: #34495e;
			    border-bottom: 3px solid #009688;
			    padding-left: 10px;
				padding-right: 10px;
			}
			.nav-md .container.body .right_col {
				padding-top: 20px;
			}
			.nav-md .container.body .right_col, .nav-md .container.body .top_nav {
				margin-top: 50px;
			}
			body .container.body .right_col {
			    background: #ecf0f5;
			}
			.nav.navbar-nav>li>a {
			    color: #ffffff!important;
			}
			.nav.navbar-nav>li>a:hover {
			    color: #009688!important;
			}
		</style>
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="">
				<div class="top_nav">
					<header class="main-header">
						<nav class="navbar navbar-static-top">
							<div class="container">
								<div class="navbar-header">
									<a href="<?php echo base_url_admin(); ?>" class="navbar-brand"><b>APLIKASI PENUNJANG KINERJA DAN NOTULENSI</b></a>
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
									<i class="fa fa-bars"></i>
									</button>
								</div>
								<div class="collapse navbar-collapse pull-right" id="navbar-collapse">
									<ul class="nav navbar-nav">
										<li class="active"><a href="<?php echo base_url_admin(); ?>">Beranda</a></li>
										<li><a href="<?php echo base_url_admin(); ?>login">Log In</a></li>
									</ul>
								</div>
							</div>
						</nav>
					</header>
				</div>
				<div class="right_col" role="main">
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="x_panel">
								<div class="x_content">
									<div class="" role="tabpanel" data-example-id="togglable-tabs">
										<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
											<li role="presentation" class=" active">
												<a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Daftar Agenda</b></a>
											</li>
										</ul>
										<div id="myTabContent2" class="tab-content">
											<div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="profile-tab">
												<div id='calendar-2'></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="x_panel">
								<div class="x_content">
									<div class="" role="tabpanel" data-example-id="togglable-tabs">
										<ul id="myTab2" class="nav nav-tabs bar_tabs" role="tablist">
											<li role="presentation" class=" active">
												<a href="#tab-content-2" role="tab" id="profile-tab-2" data-toggle="tab" aria-expanded="false"><b>Notulensi Terbaru</b></a>
											</li>
										</ul>
										<div id="myTabContent2" class="tab-content">
											<div role="tabpanel" class="tab-pane fade active in" id="tab-content-2" aria-labelledby="profile-tab">
												<?php foreach ($notulen as $data_notulen) { ?>
												<div class="project_detail">
													<h5><?= $data_notulen['notulen_rapat'];?></h5>
													<!-- <p class="title">Client Company</p> -->
													<!-- <p><?= $data_notulen['notulen_pembahasan'];?></p> -->
													<a href=""><i class="fa fa-calendar-o"></i> <?= tgl_indo($data_notulen['notulen_date']);?></a>
												</div>
												<hr />
												<?php } ?>
											</div>
										</div>
									</div>
									<br />
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer>
					<div class="text-center">
						Dinas Komunikasi dan Informatika &copy; 2018.
					</div>
					<div class="clearfix"></div>
				</footer>
			</div>
		</div>
		<!-- jQuery -->
		<script src="<?php echo asset_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="<?php echo asset_url(); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo asset_url(); ?>vendors/fastclick/lib/fastclick.js"></script>
		<!-- NProgress -->
		<script src="<?php echo asset_url(); ?>vendors/nprogress/nprogress.js"></script>
		<!-- Custom Theme Scripts -->
		<script src="<?php echo asset_url(); ?>build/js/custom.min.js"></script>
		<!-- FullCalendar -->
		<link href="<?php echo asset_url(); ?>vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
		<link href="<?php echo asset_url(); ?>vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
		<style type="text/css">
			.fc-event-container > .fc-day-grid-event {
				cursor: pointer;
			}
			.fc-content > .fc-title {
				line-height: 22px;
			}
		</style>
		<script src="<?php echo asset_url(); ?>vendors/moment/min/moment.min.js"></script>
		<script src="<?php echo asset_url(); ?>vendors/fullcalendar/dist/fullcalendar.min.js"></script>
		<script type="text/javascript">
			jQuery(function($) {
				$('#external-events div.external-event').each(function() {
					var eventObject = {
						title: $.trim($(this).text())
					};
					$(this).data('eventObject', eventObject);
					$(this).draggable({
						zIndex: 999,
						revert: true,
						revertDuration: 0
					});
				});

				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();
				var calendar = $('#calendar-2').fullCalendar({
					defaultView: 'listWeek',
					navLinks: true, // can click day/week names to navigate views				
					eventLimit: true, // allow "more" link when too many events
					buttonText: {
						today: 'Hari Ini',
						month: 'Bulan',
						week: 'Minggu',
						day: 'Hari',
						list: 'Daftar Agenda'
					},
					titleFormat: 'D MMMM YYYY',   //whatever date format you want here
					columnFormat: 'ddd',
					timeFormat: 'H:mm',
					buttonHtml: {
						prev: '<i class="ace-icon fa fa-chevron-left"></i>',
						next: '<i class="ace-icon fa fa-chevron-right"></i>'
					},
				
					header: {
						left: 'prev,next',
						center: 'title',
						// right: 'today, month,agendaWeek,agendaDay, list'
						right: 'listWeek'
					},
					noEventsMessage: 'Tidak ada agenda yang ditampilkan',
					events: function(start, end, timezone, callback) {
				//alert(start, 'Asia/Jakarta')
						$.ajax({
							url: '<?php echo base_url_admin() ?>home/data_json',
							dataType: 'json',
							data: {
								start: start.unix(),
								end: end.unix()
							},
							success: function(msg) {
								var events = msg.events;
								callback(events);
							}
						});
					},
					editable: false,
					droppable: false,
					selectable: false,
					selectHelper: true,
					dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
					dayNamesShort: ['Mng', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
					monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
					monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
					eventClick: function(calEvent, jsEvent, view) {

						//display a modal
						var modal = 
						'<div class="modal fade">\
							<div class="modal-dialog">\
								<div class="modal-content">\
									<div class="modal-header">\
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 16px;">&times;</button>\
										<h5 class="smaller lighter blue no-margin">Agenda Kegiatan</h5>\
									</div>\
									<div class="modal-body">\
										<table>\
											<tr>\
												<td>Tanggal</td><td width="25px" class="text-center">:</td><td>' + calEvent.tanggal + '</td>\
											</tr>\
											<tr>\
												<td>Waktu</td><td width="25px" class="text-center">:</td><td>' + calEvent.waktu + '</td>\
											</tr>\
											<tr>\
												<td>Acara</td><td width="25px" class="text-center">:</td><td>' + calEvent.title + '</td>\
											</tr>\
											<tr>\
												<td>Catatan</td><td width="25px" class="text-center">:</td><td>' + calEvent.notes + '</td>\
											</tr>\
										</table>\
									</div>\
									<div class="modal-footer" style="padding-top: 5px; padding-bottom: 5px;">\
										<button type="button" class="btn btn-sm btn-danger btn-flat" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Close</button>\
									</div>\
								</div>\
							</div>\
						</div>';
						var modal = $(modal).appendTo('body');
						//calEvent.title = $(this).find("#title_event").val();
						modal.modal('show').on('hidden', function(){
							modal.remove();
						});
					}
				});
			});
		</script>
	</body>
</html>