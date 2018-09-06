<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <?php $current = current_url(); ?>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php $menus = $this->session->userdata('menus');?>
            <li class="header">Menu Utama</li>
            <?php foreach ($menus as $i => $menu) { ?>
                <?php if(!isset($menu['children'])){ ?>
                    <?php
                        // set active
                        $class = '';
                        if(base_url_admin().$menu['url'] == $current){
                            $class = 'active';
                        }
                    ?>
                    <li class="<?php echo $class ?>">
                        <a href="<?php echo base_url_admin().$menu['url'] ?>">
                            <i class="<?php echo $menu['icon']; ?>"></i> <span><?php echo $menu['name'] ?></span>
                        </a>
                    </li>
                <?php }else{ ?>
                    <?php
                        // set active
                        $class = '';
                        foreach ($menu['children'] as $j => $menu2) {
                            if(base_url_admin().$menu2['url'] == $current){
                                $class = 'active';
                            }elseif(strpos($current, base_url_admin().$menu2['url']) !== false){
                                $class = 'active';
                            }
                        }
                    ?>
                    <li class="treeview <?php echo $class ?>">
                        <a href="#">
                            <i class="<?php echo $menu['icon']; ?>"></i> <span><?php echo $menu['name'] ?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu['children'] as $j => $menu2) {?>
                                <?php
                                    // set active
                                    $class = '';
                                    if(base_url_admin().$menu2['url'] == $current){
                                        $class = 'active';
                                    }elseif(strpos($current, base_url_admin().$menu2['url']) !== false){
                                        $class = 'active';
                                    }
                                ?>
                                <li class="<?php echo $class ?>"><a href="<?php echo base_url_admin().$menu2['url'] ?>"><i class="fa fa-circle-o"></i> <?php echo $menu2['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
            <li>
                <a href="<?php echo base_url_admin().'login/signout' ?>">
                    <i class="fa fa-sign-out"></i> <span>Sign Out</span>
                </a>
            </li>

            <!-- <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>