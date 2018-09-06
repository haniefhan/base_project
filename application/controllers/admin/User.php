<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model", 'user');
		$this->title = 'User';
		$this->redirect_url = base_url_admin().'user';
		$this->lang->load('user', $this->session->userdata('lang'));
	}

	function index(){
		$data['title']		= $this->title;
		$data['content']	= 'content/user/index';
		$this->user->select('user.*, group.name as group_name');
		$this->user->join('group');
		$this->user->order_by('user.id','DESC');
		$data['datas']		= array();// $this->user->get_all();
		$data['datatable']	= base_url_admin().'user/datatable';

		$this->template($data);
	}

	// add Page by form
	function add(){
		$data['title']		= 'Add New '.$this->title;
		$data['state']		= 'add';
		$data['content']	= 'content/user/form';
		
		$this->load->model('Group_model', 'group');
		$this->group->order_by('id', 'DESC');
		$data['group']		= $this->group->get_all();

		$this->template($data);
	}

	// edit Page by form
	function edit(){
		$id = $this->input->get('id');
		$data['title']		= 'Edit '.$this->title;
		$data['state']		= 'edit';
		$data['content']	= 'content/user/form';
		$data['datas'] 		= $this->user->get($id);
		$data['id'] 		= $id;
		
		$this->load->model('Group_model', 'group');
		$this->group->order_by('id', 'DESC');
		$data['group']		= $this->group->get_all();

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();
		$data['password'] = genpass($data['password']);

		if($this->user->insert($data)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Add new user success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Add new user failed');
		}

		$this->db->trans_complete();

		redirect($this->redirect_url);
	}

	function update(){
		$this->db->trans_start();
		$id = $this->input->get('id');
		$data = $this->input->post();
		if($data['password'] != '') $data['password'] = genpass($data['password']);
		else unset($data['password']);

		$id = $this->user->update($id, $data);
		if($id !== false){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Update user success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Update user failed');
		}
		$this->db->trans_complete();

		redirect($this->redirect_url);
	}

	function delete(){
		$id = $this->input->get('id');
		if($this->user->delete($id)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Delete user success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Delete user failed');
		}
		redirect($this->redirect_url);
	}

	public function datatable(){
		$this->lang->load('table', $this->session->userdata('lang'));

		$this->user->dt_indexs 		= array('user.id', 'username', 'user.name', 'email', 'group.name as group_name', 'user.id');
		$this->user->dt_join 		= array('group');
		$this->user->dt_action_index = 5;
		$this->user->dt_edit_action = true;
		$this->user->dt_delete_action = true;
		$this->user->dt_url_action 	= base_url().$this->config->item('index_page').'/admin/user/';
		$this->user->dt_index_edit 	= 'id';
		$this->user->dt_edit_label 	= lang('edit');
		$this->user->dt_delete_label = lang('delete');

		echo $this->user->datatable();
	}
}
?>