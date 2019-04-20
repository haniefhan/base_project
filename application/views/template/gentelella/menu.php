
<?php
    function get_base_current_url(){
        $current = current_url();
        $cur = explode('?', $current);
        $current = $cur[0];

        // remove index, add, edit
        $arr_remove = array('index', 'add', 'edit');
        $cur = explode('/', $current);

        $current = '';
        foreach ($cur as $i => $cr) {
            if($i == (count($cur) - 1)){
                if(!in_array($cr, $arr_remove)){
                    if($current != '') $current .= '/';
                    $current .= $cr;
                }
            }else{
                if($current != '') $current .= '/';
                $current .= $cr;
            }
        }

        return $current;
    }
    
    function parse_menu($menu = array()){
        $current = get_base_current_url();
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
                // $class .= ' treeview ';
                if($status == 1){
                    $class .= ' active ';
                }
            }
        }

        $onclick = '';
        if($html_children != ''){
        	$onclick = 'onclick="return false;"';
        }
        
        $html  = '<li class="'.$class.'">';
        $html .= '   <a href="'.base_url_admin().$menu_ini['url'].'" title="'.$menu_ini['name'].'" '.$onclick.'>';
        $html .= '       <i class="'.$menu_ini['icon'].'"></i> '.$menu_ini['name'];
        if($html_children != ''){
            $html .= '          <span class="fa fa-chevron-down"></span>';
        }
        $html .= '   </a>';
        if($html_children != ''){
            $html .= '  <ul class="nav child_menu">';
            $html .= '  '.$html_children;
            $html .= '  </ul>';
        }
        $html .= '</li>';

        return array($html, $status);
    }
?>
<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="<?php echo base_url_admin() ?>" class="site_title"><i class="fa fa-laptop"></i> <span><?php echo $this->session->userdata('site_title'); ?></span></a>
		</div>

		<div class="clearfix"></div>

		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="<?php echo asset_admin_url().'production/images/tester.png'; ?>" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Selamat Datang,</span>
				<h2><?php echo $this->session->userdata('name') ?></h2>
			</div>
		</div>

		<br />

		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<?php $current = get_base_current_url(); ?>
			<div class="menu_section">
				<?php $menus = $this->session->userdata('menus');?>
				<ul class="nav side-menu">
					<?php foreach ($menus as $menu) {?>
						<?php $m = parse_menu($menu); echo $m[0]; ?>
					<?php } ?>
					<li>
						<a href="<?php echo base_url_admin().'login/signout' ?>"><i class="fa fa-sign-out"></i> Sign Out</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>