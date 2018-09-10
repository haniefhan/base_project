<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Group_model", 'group');
		$this->title = 'Group';
		$this->controller = 'group';
		$this->redirect_url = base_url_admin().'group';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'group/datatable';

		// because it's simple index and form, use common form
		$data['table_field'] = $this->group->table_field;
		$data['content']	= 'content/common/index';

		$this->template($data);
	}

	// add Page by form
	function add(){
		$data = array();
		$data['title']		= 'Add New '.$this->title;
		$data['controller']	= $this->controller;
		$data['state']		= 'add';

		// because it's simple index and form, use common form
		$data['table_field'] = $this->group->table_field;
		$data['primary_key'] = $this->group->primary_key;
		$data['content']	= 'content/common/form';
		$this->template($data);
	}

	// edit Page by form
	function edit(){
		$id = $this->input->get('id');
		$data = array();
		$data['title']		= 'Edit '.$this->title;
		$data['controller']	= $this->controller;
		$data['state']		= 'edit';
		$data['id'] 		= $id;

		// because it's simple index and form, use common form
		$data['table_field'] = $this->group->table_field;
		$data['primary_key'] = $this->group->primary_key;
		$data['content']	= 'content/common/form';
		$data['datas']      = $this->group->get($id);

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		if($this->group->insert($data)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Add new '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Add new '.$this->title.' failed');
		}

		$this->db->trans_complete();

		redirect($this->redirect_url);
	}

	function update(){
		$this->db->trans_start();
		$id = $this->input->get('id');
		$data = $this->input->post();

		$st = $this->group->update($id, $data);
		if($st !== false){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Update '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Update '.$this->title.' failed');
		}
		$this->db->trans_complete();

		redirect($this->redirect_url);
	}

	function delete(){
		$id = $this->input->get('id');
		if($this->group->delete($id)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' failed');
		}
		redirect($this->redirect_url);
	}

	public function datatable(){
		$indexs = $this->group->get_dt_table_field();
		$this->group->dt_indexs        = $indexs;// array('gn_id', 'gn_name', "gn_id");

		$this->group->dt_action_index  = (count($indexs) - 1);
		$this->group->dt_edit_action   = true;
		$this->group->dt_delete_action = true;
		$this->group->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->group->dt_index_edit    = 'id';
		// $this->group->dt_where       = array("user_id" => $this->session->userdata('id'));

		echo $this->group->datatable();
	}
}
?>