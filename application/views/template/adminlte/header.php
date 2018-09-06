<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url_admin(); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>LTE</span>
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
                        <!-- <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div> -->
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