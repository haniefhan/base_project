<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Menu_model", 'menu');
		$this->title = 'Menu';
		$this->controller = 'menu';
		$this->redirect_url = base_url_admin().'menu';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'menu/datatable';

		// because it's simple index and form, use menu form
		$data['table_field'] = $this->menu->table_field;
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
		$data['table_field'] = $this->menu->table_field;
		foreach ($data['table_field'] as $i => $tf) {
			if($tf['type'] == 'select'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->$tf['value'][0]->populate_select($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}
		}
		$data['primary_key'] = $this->menu->primary_key;
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
		$data['table_field'] = $this->menu->table_field;
		foreach ($data['table_field'] as $i => $tf) {
			if($tf['type'] == 'select'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->$tf['value'][0]->populate_select($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}
		}
		$data['primary_key'] = $this->menu->primary_key;
		$data['content']	= 'content/common/form';
		$data['datas']      = $this->menu->get(decrypt_id($id));

		$data['datas'] = $this->menu->reformat_sql_to_form($data['datas']);

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		$data = $this->menu->reformat_post_to_sql($data);

		if($this->menu->insert($data)){
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
		$id = decrypt_id($this->input->get('id'));
		$data = $this->input->post();

		$data = $this->menu->reformat_post_to_sql($data);

		$st = $this->menu->update($id, $data);
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
		$id = decrypt_id($this->input->get('id'));

		if($this->menu->delete($id)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' failed');
		}
		redirect($this->redirect_url);
	}

	public function datatable(){
		$indexs = $this->menu->get_dt_table_field();

		// if use join and 'as' in SELECT
		// $dt_join = array();
		// foreach ($indexs as $i => $index) {
		// 	if($index == 'parent'){
		// 		$indexs[$i] = 'menu.parent as parent_name';
		// 		$dt_join[] = 'menu';
		// 	}
		// }

		// if(count($dt_join) > 0) $this->menu->dt_join = $dt_join;

		$this->menu->dt_indexs        = $indexs;
		$this->menu->dt_action_index  = (count($indexs) - 1);
		$this->menu->dt_edit_action   = true;
		$this->menu->dt_delete_action = true;
		$this->menu->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->menu->dt_index_edit    = 'id';
		// $this->menu->dt_where       = array("user_id" => $this->session->userdata('id'));
		
		echo $this->menu->datatable();
	}
}
?>