<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url_admin(); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <!-- <span class="logo-mini"><b>A</b>LT</span> -->
    <!-- logo for regular state and mobile devices -->
    <!-- <span class="logo-lg"><b>Admin</b>LTE</span> -->
    <span class="logo-lg"><?php echo $this->session->userdata('site_title'); ?></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <?php if($notification['new'] > 0){ ?>
                        <span class="label label-danger"><?php echo $notification['new']; ?></span>
                    <?php } ?>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have <?php echo $notification['new']; ?> new notifications</li>
                    <li>
                        <ul class="menu">
                            <?php foreach ($notification['datas'] as $data) {?>
                                <?php 
                                    $color = '#666666';
                                    if($data['ntf_read'] == 1){
                                        $color = '#DDDDDD';
                                    }
                                ?>
                                <li>
                                    <a href="<?php echo base_url_admin().'notification/read?id='.$data['ntf_id']; ?>">
                                        <h3 style="color: <?php echo $color; ?>;">
                                            <?php echo $data['ntf_content'] ?><small class="pull-right" title="<?php echo date('d/m/Y H:i', strtotime($data['create_date'])); ?>" style="color: <?php echo $color; ?>;"><i class="fa fa-clock-o"></i> <?php echo $data['ago']; ?></small>
                                        </h3>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="footer"><a href="<?php echo base_url_admin().'notification'; ?>">View all</a></li>
                </ul>
            </li>
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo asset_admin_url() ?>dist/img/avatar.png" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo $this->session->userdata('name'); ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="<?php echo asset_admin_url() ?>dist/img/avatar.png" class="img-circle" alt="User Image">

                        <p>
                            <?php echo $this->session->userdata('name'); ?>
                            <small><?php echo $this->session->userdata('email'); ?></small>
                            <!-- Alexander Pierce - Web Developer
                            <small>Member since Nov. 2012</small> -->
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- <li class="user-body">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </div>
                    </li> -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?php echo base_url_admin().'profile' ?>" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo base_url_admin().'login/signout' ?>" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
</header>