<?php
class Notification_model extends MY_Model {
	protected $_table 		= 'notification';
	public $primary_key 	= 'ntf_id';

	public $belongs_to = array(
		'menu' => array('from_column' => 'menu_id', 'to_column' => 'id'),
		'user' => array('from_column' => 'user_id', 'to_column' => 'id'),
	);

	public $table_field = array(
		array(
			// table param
			'name' 			=> 'No',
			'table_index'	=> 'ntf_id',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'hidden',
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Title',
			'table_index'	=> 'ntf_title',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text',
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Content',
			'table_index'	=> 'ntf_content',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text',
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Type',
			'table_index'	=> 'ntf_type',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select-simple',
			'value' 		=> array(1 => 'Add', 2 => 'Edit', 3 => 'Delete'),
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'URL',
			'table_index'	=> 'ntf_url',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text',
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Is Read',
			'table_index'	=> 'ntf_read',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select-simple',
			'value' 		=> array(0 => 'Unread', 1 => 'Read'),
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'User',
			'table_index'	=> 'user_id',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select',
			'value' 		=> array('User_model', 'user.id', 'user.name', array()),
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Menu',
			'table_index'	=> 'menu_id',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select',
			'value' 		=> array('Menu_model', 'menu.id', 'menu.name', array()),
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
	);

	// 1 : add, 2 : edit, 3 : delete
	public $notif_types = array(1 => 'Add', 2 => 'Edit', 3 => 'Delete');

	public function get_notification(){
		$datas = array();
		$datas['new'] = $this->count_by(array('ntf_read' => 0));
		$datas['datas'] = array();

		$this->limit(15);
		$this->order_by('create_date', 'DESC');
		foreach ($this->get_all() as $i => $data) {
			$datas['datas'][$i] = $data;
			$datas['datas'][$i]['ago'] = $this->timeAgo($data['create_date']);
		}

		return $datas;
	}

	public function add_notification($type = 1, $menu_id = 0, $url = '', $user_ids = array(), $title = '', $content = ''){
		if($title == '' || $content == '' || $url == ''){
			$this->load->model('Menu_model', 'menu');
			$menu = $this->menu->get_by(array('id' => $menu_id));
			
			if($url == ''){
				$url = $menu['url'];
			}

			if($title == ''){
				if(isset($this->notif_types[$type])){
					$title = $this->notif_types[$type].' '.$menu['name'];
				}else{
					$title = 'Undefined Action in '.$menu['name'];
				}
			}

			if($content == ''){
				$content = $title.' by '.$this->session->userdata('name');
			}
		}

		if(count($user_ids) == 0){
			$user_ids[] = $this->session->userdata('id');
		}

		$datas = array();

		// notification for many user
		foreach ($user_ids as $user_id) {
			$datas[] = array(
				'ntf_title' => $title,
				'ntf_content' => $content,
				'ntf_type' => $type,
				'ntf_url' => $url,
				'user_id' => $user_id,
				'menu_id' => $menu_id,
				'create_date' => date('Y-m-d H:i:s'),
			);
		}

		if(count($datas) > 0) $this->insert_batch($datas);
	}

	function timeAgo($time_ago){
	    $time_ago = strtotime($time_ago);
	    $cur_time   = time();
	    $time_elapsed   = $cur_time - $time_ago;
	    $seconds    = $time_elapsed ;
	    $minutes    = round($time_elapsed / 60 );
	    $hours      = round($time_elapsed / 3600);
	    $days       = round($time_elapsed / 86400 );
	    $weeks      = round($time_elapsed / 604800);
	    $months     = round($time_elapsed / 2600640 );
	    $years      = round($time_elapsed / 31207680 );
	    // Seconds
	    if($seconds <= 60){
	        return "just now";
	    }
	    //Minutes
	    else if($minutes <=60){
	        if($minutes==1){
	            return "one minute ago";
	        }
	        else{
	            return "$minutes minutes ago";
	        }
	    }
	    //Hours
	    else if($hours <=24){
	        if($hours==1){
	            return "an hour ago";
	        }else{
	            return "$hours hrs ago";
	        }
	    }
	    //Days
	    else if($days <= 7){
	        if($days==1){
	            return "yesterday";
	        }else{
	            return "$days days ago";
	        }
	    }
	    //Weeks
	    else if($weeks <= 4.3){
	        if($weeks==1){
	            return "a week ago";
	        }else{
	            return "$weeks weeks ago";
	        }
	    }
	    //Months
	    else if($months <=12){
	        if($months==1){
	            return "a month ago";
	        }else{
	            return "$months months ago";
	        }
	    }
	    //Years
	    else{
	        if($years==1){
	            return "one year ago";
	        }else{
	            return "$years years ago";
	        }
	    }
	}
}
?>