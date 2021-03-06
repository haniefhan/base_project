<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Menugroup_model", 'access');
		$this->title = 'Access Right';
		$this->controller = 'access';
		$this->redirect_url = base_url_admin().'access';
	}

	function index(){
		$data['title']		= $this->title;
		$data['content']	= 'content/access/index';

		$this->load->model("Group_model", 'group');
		$data['group']		= $this->group->get_all();

		$this->template($data);
	}

	function add(){}

	function edit(){
		$id = $this->input->get('id');
		if($id != ''){
			$data['title']		= $this->title;
			$data['content']	= 'content/access/index';
			$data['id']			= $id;

			$data['datas']		= $this->access->menugroup_structured($id);

			$this->load->model("Group_model", 'group');
			$data['group']		= $this->group->get_all();

			$this->load->model("Menu_model", 'menu');
			$data['menus']		= $this->menu->menu_structured();
			$data['access_name'] = $this->menu->all_access_name();

			$this->template($data);
		}else{
			redirect($this->redirect_url);
		}
	}

	function insert(){}

	function update(){
		$this->load->model("Menu_model", 'menu');
		$access = $this->menu->access_name();

		$id = $this->input->get('id');
		$post = $this->input->post();
		$data = array();
		if(isset($post['menus'])){
			// foreach ($data as $i => $v) {
			// 	foreach ($access as $acc) {
			// 		if(!isset($data[$i][$acc])) $data[$i][$acc] = 0;
			// 	}
			// 	$data[$i]['group_id'] = $id;
			// 	$data[$i]['menu_id'] = $i;
			// }
			foreach ($post['menus'] as $menu_id => $menu) {
				$data[$menu_id]['menu_id'] = $menu_id;
				$data[$menu_id]['group_id'] = $id;
				$data[$menu_id]['access_grant'] = json_encode($menu);
			}
		}
		
		$this->db->trans_start();
		$this->access->delete_by(array('group_id' => $id));

		if(count($data) > 0) $this->access->insert_batch($data);
		$this->db->trans_complete();

		if($this->db->trans_status()){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Set access right has been success. Please <a href="'.base_url_admin().'login/signout" class="btn btn-danger btn-xs">Sign Out</a> to look the change');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Set access right has been failed.');
		}

		redirect($this->redirect_url.'/edit?id='.$id);
	}

	function delete(){}
}
?>