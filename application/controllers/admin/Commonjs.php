<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Commonjs extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Common_model", 'common');
		$this->title = 'Common JS';
		$this->controller = 'commonjs';
		$this->redirect_url = base_url_admin().'commonjs';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'commonjs/datatable';

		// because it's simple index and form, use common form
		$data['content']	= 'content/common/indexjs';
		$data['state']		= 'js';
		$data['table_field'] = $this->common->table_field;
		foreach ($data['table_field'] as $i => $tf) {
			if($tf['type'] == 'select'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}elseif($tf['type'] == 'select-year'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select_year($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}elseif($tf['type'] == 'select-simple'){
				$data['table_field'][$i]['value'] = $tf['value'];
			}
		}
		$data['primary_key'] = $this->common->primary_key;

		$this->template($data);
	}

	function add(){}

	function edit(){
		$id = $this->input->get('id');
		$data = $this->common->get(decrypt_id($id));
		$data = $this->common->reformat_sql_to_form($data);
		echo json_encode($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		$data = $this->common->reformat_post_to_sql($data);

		$return = array();
		// confirm password
		if($data['com_password'] != $data['confirm_password']){
			$return['notif_status'] = false;
			$return['notif_msg'] = 'Password and Confirm Password must be same!';
		}elseif($data['com_password'] != ''){
			$data['com_password'] = genpass($data['com_password']);
			unset($data['confirm_password']);
		}
		// end of confirm password

		// upload file
		$files = $_FILES;
		foreach ($files as $index => $file) {
			if($file['error'] === 0){
				$this->securefile->allowed_file_type = 'jpg|png|jpeg';
				$data[$index] = $this->securefile->save_file($file);
				if($data[$index] == false){
					$filetype = explode('|', $this->securefile->allowed_file_type);
					$return['notif_status'] = false;
					$return['notif_msg'] = 'File upload failed, because file type not allowed. (Allowed file type : '.implode(', ', $filetype).')';
				}
			}
		}
		// end of upload file

		if(count($return) == 0){
			if($this->common->insert($data)){
				$return['notif_status'] = true;
				$return['notif_msg'] = 'Add new '.$this->title.' success';
			}else{
				$return['notif_status'] = false;
				$return['notif_msg'] = 'Add new '.$this->title.' failed';
			}
		}

		$this->db->trans_complete();
		echo json_encode($return);
	}

	function update(){
		$this->db->trans_start();
		$id = decrypt_id($this->input->get('id'));
		$data = $this->input->post();

		$data = $this->common->reformat_post_to_sql($data);

		// confirm password
		if($data['com_password'] != '' AND ($data['com_password'] != $data['confirm_password'])){
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Password and Confirm Password must be same!');
			$this->db->trans_complete();
			redirect($this->redirect_url);
		}elseif($data['com_password'] != ''){
			$data['com_password'] = genpass($data['com_password']);
			unset($data['confirm_password']);
		}else{
			unset($data['com_password']);
			unset($data['confirm_password']);
		}
		// end of confirm password

		// upload file
		$files = $_FILES;
		foreach ($files as $index => $file) {
			if($file['error'] === 0){
				$this->securefile->allowed_file_type = 'jpg|png|jpeg';
				$data[$index] = $this->securefile->save_file($file);
				if($data[$index] == false){
					$filetype = explode('|', $this->securefile->allowed_file_type);
					$this->session->set_flashdata('notif_status', false);
					$this->session->set_flashdata('notif_msg', 'File upload failed, because file type not allowed. (Allowed file type : '.implode(', ', $filetype).')');
					$this->db->trans_complete();
					redirect($this->redirect_url);
				}
			}
		}
		// end of upload file

		$st = $this->common->update($id, $data);
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

		// delete the file uploaded
		$data = $this->common->get($id);
		if($data['file'] != ''){
			$this->securefile->delete_file($data['file']);
		}
		// end of delete the file uploaded

		$return = array();
		if($this->common->delete($id)){
			$return['notif_status'] = true;
			$return['notif_msg'] = 'Delete '.$this->title.' success';
		}else{
			$return['notif_status'] = false;
			$return['notif_msg'] = 'Delete '.$this->title.' failed';
		}
		echo json_encode($return);
	}

	public function datatable(){
		$uri = str_replace('/datatable', '', uri_string());
		$indexs = $this->common->get_dt_table_field();

		// if use join and 'as' in SELECT
		$dt_join = array();
		foreach ($indexs as $i => $index) {
			if($index == 'group_id'){
				// concat example
				// $indexs[$i] = "CONCAT(jenjang_name, ' - ', prodi_name)";
				// $this->konsentrasi->dt_join = array('mst_prodi', 'mst_jenjang');
				$indexs[$i] = 'group.name as group_name';
				$dt_join[] = 'group';
			}elseif($index == 'com_jk'){
				$indexs[$i] = "CASE com_jk WHEN 1 THEN 'Laki-Laki' WHEN 2 THEN 'Perempuan' END as jk";
			}
		}

		if(count($dt_join) > 0) $this->common->dt_join = $dt_join;

		$this->common->dt_indexs        = $indexs;
		$this->common->dt_action_index  = (count($indexs) - 1);
		$this->common->dt_edit_action   = check_access_menu($uri.'/edit');
		$this->common->dt_delete_action = check_access_menu($uri.'/delete');
		$this->common->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->common->dt_index_edit    = 'id';

		echo $this->common->datatable();
	}
}
?>