<?php
if(!function_exists('set_access_grant')){
	function set_access_grant($menu = array()){
		$menu_ini = $menu;
		$admin_folder = 'admin/';
		$acc_grant = array();
		$in_access = array();

		// if($menu_ini['view'] == 1){
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/index';
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'];
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/datatable';
		// 	$in_access[$menu_ini['url']] = $menu_ini['url'];
		// }

		// if($menu_ini['add'] == 1){
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/add';
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/insert';
		// }

		// if($menu_ini['edit'] == 1){
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/edit';
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/update';
		// }

		// if($menu_ini['delete'] == 1){
		// 	$acc_grant[] = $admin_folder.$menu_ini['url'].'/delete';
		// }

		// if(count($menu_ini['children']) > 0){
		// 	foreach ($menu_ini['children'] as $chd) {
		// 		list($acc_grant2, $in_access2) = set_access_grant($chd);
		// 		$acc_grant = array_merge($acc_grant, $acc_grant2);
		// 		$in_access = array_merge($in_access, $in_access2);
		// 	}
		// }
		
		foreach (json_decode($menu_ini['access_manage'], true) as $mi) {
			if($mi == 'view'){
				$acc_grant[] = $admin_folder.$menu_ini['url'];
				$acc_grant[] = $admin_folder.$menu_ini['url'].'/index';
			}else{
				$acc_grant[] = $admin_folder.$menu_ini['url'].'/'.$mi;
			}
			$in_access[$menu_ini['url']] = $menu_ini['url'];
		}

		if(count($menu_ini['children']) > 0){
			foreach ($menu_ini['children'] as $chd) {
				list($acc_grant2, $in_access2) = set_access_grant($chd);
				$acc_grant = array_merge($acc_grant, $acc_grant2);
				$in_access = array_merge($in_access, $in_access2);
			}
		}

		return array($acc_grant, $in_access);
	}
}

if(!function_exists('set_menu')){
	function set_menu($group_id = 0){
		$CI = & get_instance();
		if($CI->session->userdata('menus')){
			return $CI->session->userdata('menus');
		}else{
			$CI->load->model('Menu_model', 'menu');
			$res = $CI->menu->menu_structured($group_id);

			$acc_grant = array();
			$in_access = array();

			$admin_folder = 'admin/';

			foreach ($res as $i => $menu) {
				list($acc_grant2, $in_access2) = set_access_grant($menu);
				$acc_grant = array_merge($acc_grant, $acc_grant2);
				$in_access = array_merge($in_access, $in_access2);
			}
			
			/*$admin_folder = 'admin/';
			$CI->db->select('id, name, url, icon, parent, order');
			$CI->db->select('view, add, edit, delete');
			$CI->db->join('menu', 'menugroup.menu_id = menu.id', 'LEFT');
			$CI->db->where('group_id', $group_id);
			$CI->db->where('menu.status', 1);
			$res = $CI->db->get('menugroup')->result_array();

			// $res = $CI->db->get('menu')->result_array();
			
			$tree = array();
			$child = array();
			$acc_grant = array();
			$in_access = array();

			foreach ($res as $i => $v) {
				if($v['parent'] != 0){
					$child[$v['parent']][(int)$v['order']] = $v;
					unset($res[$i]);

					if($v['view'] == 1){
						$acc_grant[] = $admin_folder.$v['url'].'/index';
						$acc_grant[] = $admin_folder.$v['url'];
						$acc_grant[] = $admin_folder.$v['url'].'/datatable';
						$in_access[$v['url']] = $v['url'];
					}

					if($v['add'] == 1){
						$acc_grant[] = $admin_folder.$v['url'].'/add';
						$acc_grant[] = $admin_folder.$v['url'].'/insert';
					}

					if($v['edit'] == 1){
						$acc_grant[] = $admin_folder.$v['url'].'/edit';
						$acc_grant[] = $admin_folder.$v['url'].'/update';
					}

					if($v['delete'] == 1){
						$acc_grant[] = $admin_folder.$v['url'].'/delete';
					}
				}
			}
			
			foreach ($res as $i => $v) {
				$tree[(int)$v['order']] = $v;
				if(isset($child[$v['id']])){
					ksort($child[$v['id']]);
					$tree[$v['order']]['children'] = $child[$v['id']];
				}else{
					$in_arr = array();
					if($v['view'] == 1){
						$in_arr[] = 'view';
					}
					if($v['add'] == 1){
						$in_arr[] = 'add';
					}

					$chds = array();
					if(count($in_arr) > 0){
						$CI->db->where('parent', $v['id']);
						$CI->db->where_in('state', $in_arr);
						$chds = $CI->db->get('menu')->result_array();
					}

					if(count($chds > 0)){
						foreach ($chds as $chd) {
							$tree[$v['order']]['children'][] = $chd;
						}
					}
				}

				// set whitelist
				if($v['view'] == 1){
					$acc_grant[] = $admin_folder.$v['url'].'/index';
					$acc_grant[] = $admin_folder.$v['url'];
					$acc_grant[] = $admin_folder.$v['url'].'/datatable';
					$in_access[$v['url']] = $v['url'];
				}

				if($v['add'] == 1){
					$acc_grant[] = $admin_folder.$v['url'].'/add';
					$acc_grant[] = $admin_folder.$v['url'].'/insert';
				}

				if($v['edit'] == 1){
					$acc_grant[] = $admin_folder.$v['url'].'/edit';
					$acc_grant[] = $admin_folder.$v['url'].'/update';
				}

				if($v['delete'] == 1){
					$acc_grant[] = $admin_folder.$v['url'].'/delete';
				}
			}*/

			/* @haniefhan : for special case for menu like detail, or cetak */
			$CI->load->config('special_access');
			$special_access = $CI->config->item('special_access');

			if(count($special_access) > 0){
				foreach ($special_access as $url => $sps) {
					foreach ($sps as $sp) {
						if($sp != ''){
							if(in_array($url, $in_access)){
								$acc_grant[] = $admin_folder.$url.'/'.$sp;
							}
						}
						else{
							$acc_grant[] = $admin_folder.$url;
							$in_access[$url] = $url;
						}
					}
				}
			}

			ksort($res);
			
			$CI->session->set_userdata('menus', $res);
			$CI->session->set_userdata('acc_grant', $acc_grant);
		}
	}
}

if ( ! function_exists('parse_accessgrant')){
	function parse_accessgrant($url = ''){
		if(strpos($url, '?') != false){
			$u = explode('?', $url);
			$url = $u[0];
		}
		return $url;
	}
}

if ( ! function_exists('admin_template')){
	function admin_template(){
		$CI = & get_instance();
		// $CI->session->sess_destroy();
		if(!$CI->session->userdata('template_admin')){
			// get from database
			$CI->load->model('Setting_model', 'setting');
			$temp = $CI->setting->get_by(array('name' => 'template_admin'));

			$CI->load->model('Template_model', 'template');
			$template = $CI->template->get_by(array('name' => $temp['value']));

			$CI->session->set_userdata('template_admin', $template['url'].'index');
			$CI->session->set_userdata('template_login', $template['url'].'login');
			$CI->session->set_userdata('template_forgot', $template['url'].'forgot');
			$CI->session->set_userdata('template_admin_use', $template['url']);
			$CI->session->set_userdata('login_attempt', 0);
			// $CI->session->set_userdata('title', 'Sintesa Admin |');
		}
	}
}

if ( ! function_exists('login_check')){
	function login_check($redirect = false){
		$CI = & get_instance();
		if($CI->session->userdata('user_login') === true){
			return true;
		}else{
			if($redirect == true){
				redirect(base_url().$CI->config->item('index_page').'/admin');
			}
			return false;
		}
	}
}

if ( ! function_exists('button_access')){
	function button_access($state = '', $uri_string = '', $id = 0){
		$CI = & get_instance();

		// check if have /index in the last, remove it
		// ex : admin/post/index
		if(strpos($uri_string, '/index')){
			$uri_string = str_replace('/index', '', $uri_string);
		}

		if(in_array($uri_string.'/'.$state, $CI->session->userdata('acc_grant'))){
			if($state == 'edit')
				return '<a class="btn btn-success btn-xs" href="'.base_url().$CI->config->item('index_page').'/'.$uri_string.'/edit?id='.$id.'">'.$CI->lang->line('edit',$CI->session->userdata('lang')).'</a>';
			else if($state == 'delete')
				return '<a class="btn btn-danger btn-xs delete" href="'.base_url().$CI->config->item('index_page').'/'.$uri_string.'/delete?id='.$id.'">'.$CI->lang->line('delete',$CI->session->userdata('lang')).'</a>';
		}

		return '';
	}
}

if ( ! function_exists('check_access_menu')){
	function check_access_menu($url = ''){
		$CI = & get_instance();
		
		if(in_array($url, $CI->session->userdata('acc_grant'))){
			return true;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('encrypt_id')){
	function encrypt_id($id = ''){
		$CI = & get_instance();
		if($CI->config->item('use_encrypt')){
			$CI->load->library('encrypt');
			// $CI->encrypt->set_cipher('aes-192');
			$CI->encrypt->set_mode('ctr');
			$key = $CI->config->item('encryption_key_security');

			$ret = $CI->encrypt->encode($id, $key);

			$id = bin2hex($ret);
			// $id = strtr(
			// 	$ret,
			// 	array(
			// 		'+' => '.',
			// 		'=' => '-',
			// 		'/' => '~'
			// 	)
			// );
		}

		return $id;
	}
}

if ( ! function_exists('decrypt_id')){
	function decrypt_id($string = ''){
		$CI = & get_instance();
		if($CI->config->item('use_encrypt')){
			$CI->load->library('encrypt');
			// $CI->encrypt->set_cipher('aes-128');
			$CI->encrypt->set_mode('ctr');
			$key = $CI->config->item('encryption_key_security');

			$string = hex2bin($string);
			// $string = strtr(
			// 	$string,
			// 	array(
			// 		'.' => '+',
			// 		'-' => '=',
			// 		'~' => '/'
			// 	)
			// );

			$string = $CI->encrypt->decode($string, $key);

			if($string == false){
				$CI->session->set_flashdata('notif_status', false);
				$CI->session->set_flashdata('notif_msg', "No data found with the ID you entered! Please don't play with ID!");
				redirect(base_url_admin().'dashboard');
			}
		}

		return $string;
	}
}