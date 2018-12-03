<?php
    function parse_menu($menu = array()){
        $current = current_url();
        $menu_ini = $menu;
        $class = '';
        $status = 0;
        if(base_url_admin().$menu_ini['url'] == $current){
            $class = 'active';
            $status = 1;
        }
        // check if have children
        $html_children = '';
        if(isset($menu_ini['children'])){
            if(count($menu_ini['children']) > 0){
                foreach ($menu_ini['children'] as $menu_ini2) {
                    $m = parse_menu($menu_ini2);
                    $html_children .= $m[0];
                    if($status == 0){
                        $status = $m[1];
                    }
                }
                $class .= ' treeview ';
                if($status == 1){
                    $class .= ' active ';
                }
            }
        }
        
        $html  = '<li class="'.$class.'">';
        $html .= '   <a href="'.base_url_admin().$menu_ini['url'].'" title="'.$menu_ini['name'].'">';
        $html .= '       <i class="'.$menu_ini['icon'].'"></i> <span>'.$menu_ini['name'].'</span>';
        if($html_children != ''){
            $html .= '          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
        }
        $html .= '   </a>';
        if($html_children != ''){
            $html .= '  <ul class="treeview-menu">';
            $html .= '  '.$html_children;
            $html .= '  </ul>';
        }
        $html .= '</li>';

        return array($html, $status);
    }
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <?php $current = current_url(); ?>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php $menus = $this->session->userdata('menus');?>
            <li class="header">Menu Utama</li>
            <?php foreach ($menus as $i => $menu) { ?>
                <?php $m = parse_menu($menu); echo $m[0]; ?>
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
<style type="text/css">
    ul.sidebar-menu li a{
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
</style>