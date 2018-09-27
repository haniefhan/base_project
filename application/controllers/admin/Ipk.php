<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ipk extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Ipk_model", 'ipk');
		$this->title = 'IPK';
		$this->controller = 'ipk';
		$this->redirect_url = base_url_admin().'ipk';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'ipk/datatable';

		// because it's simple index and form, use ipk form
		$data['table_field'] = $this->ipk->table_field;
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
		$data['table_field'] = $this->ipk->table_field;
		$data['primary_key'] = $this->ipk->primary_key;
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
		$data['table_field'] = $this->ipk->table_field;
		$data['primary_key'] = $this->ipk->primary_key;
		$data['content']	= 'content/common/form';
		$data['datas']      = $this->ipk->get($id);

		$data['datas'] = $this->ipk->reformat_sql_to_form($data['datas']);

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		$data = $this->ipk->reformat_post_to_sql($data);

		if($this->ipk->insert($data)){
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

		$data = $this->ipk->reformat_post_to_sql($data);

		$st = $this->ipk->update($id, $data);
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

		if($this->ipk->delete($id)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' failed');
		}
		redirect($this->redirect_url);
	}

	public function datatable(){
		$indexs = $this->ipk->get_dt_table_field();

		$this->ipk->dt_indexs        = $indexs;
		$this->ipk->dt_action_index  = (count($indexs) - 1);
		$this->ipk->dt_edit_action   = true;
		$this->ipk->dt_delete_action = true;
		$this->ipk->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->ipk->dt_index_edit    = 'id';
		// $this->ipk->dt_where       = array("user_id" => $this->session->userdata('id'));
		
		echo $this->ipk->datatable();
	}
}
?>