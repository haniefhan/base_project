<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model("Notification_model", 'notification');
		$this->title = 'Notification';
		$this->controller = 'notification';
		$this->redirect_url = base_url_admin().'notification';
	}

	public function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'notification/datatable';

		// because it's simple index and form, use common form
		$data['table_field'] = $this->notification->table_field;
		$data['content']	= 'content/common/index';

		$this->template($data);
	}

	public function read(){
		$id = $this->input->get('id');

		$this->notification->select('ntf_url');
		$notif = $this->notification->get_by(array('ntf_id' => $id));

		$this->notification->update($id, array('ntf_read' => 1));
		redirect(base_url_admin().$notif['ntf_url']);
	}

	public function datatable(){
		$uri = str_replace('/datatable', '', uri_string());
		$indexs = $this->notification->get_dt_table_field();
		
		$dt_join = array();
		foreach ($indexs as $i => $index) {
			if($index == 'user_id'){
				$indexs[$i] = 'user.name as user_name';
				$dt_join[] = 'user';
			}elseif($index == 'menu_id'){
				$indexs[$i] = 'menu.name as menu_name';
				$dt_join[] = 'menu';
			}elseif($index == 'ntf_read'){
				$indexs[$i] = "CASE ntf_read WHEN 0 THEN 'Unread' WHEN 1 THEN 'Read' END as ntf_reads";
			}elseif($index == 'ntf_type'){
				$indexs[$i] = "CASE ntf_type ";
				foreach ($this->notification->notif_types as $index => $value) {
					$indexs[$i] .= "WHEN ".$index." THEN '".$value."' ";
				}
				$indexs[$i] .= "END as ntf_types";
			}elseif($index == 'ntf_url'){
				$indexs[$i] = "CONCAT('<a href=\"".base_url_admin()."', `ntf_url`, '\" class=\"btn btn-primary btn-xs\">Open Link</a>') as ntf_urls";
			}
		}

		if(count($dt_join) > 0) $this->notification->dt_join = $dt_join;

		$this->notification->dt_indexs        = $indexs;// array('gn_id', 'gn_name', "gn_id");

		$this->notification->dt_action_index  = -1;
		$this->notification->dt_edit_action   = check_access_menu($uri.'/edit');
		$this->notification->dt_delete_action = check_access_menu($uri.'/delete');
		$this->notification->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->notification->dt_index_edit    = 'id';
		// $this->group->dt_where       = array("user_id" => $this->session->userdata('id'));

		echo $this->notification->datatable();
	}
}
