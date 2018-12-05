<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model", 'user');
		$this->title = 'User';
		$this->controller = 'user';
		$this->redirect_url = base_url_admin().'user';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'user/datatable';

		// because it's simple index and form, use user form
		$data['table_field'] = $this->user->table_field;
		$data['content']	= 'content/common/index';

		$this->template($data);
	}

	// add Page by form
	function add(){
		$data = array();
		$data['title']		= 'Add New '.$this->title;
		$data['controller']	= $this->controller;
		$data['state']		= 'add';

		// because it's simple index and form, use user form
		$data['table_field'] = $this->user->table_field;
		foreach ($data['table_field'] as $i => $tf) {
			if($tf['type'] == 'select'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}elseif($tf['type'] == 'select-year'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select_year($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}
		}
		$data['primary_key'] = $this->user->primary_key;
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

		// because it's simple index and form, use user form
		$data['table_field'] = $this->user->table_field;
		foreach ($data['table_field'] as $i => $tf) {
			if($tf['type'] == 'select'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}elseif($tf['type'] == 'select-year'){
				$this->load->model($tf['value'][0]);
				$data['table_field'][$i]['value'] = $this->{$tf['value'][0]}->populate_select_year($tf['value'][1], $tf['value'][2], $tf['value'][3]);
			}
		}
		$data['primary_key'] = $this->user->primary_key;
		$data['content']	= 'content/common/form';
		$data['datas']      = $this->user->get(decrypt_id($id));

		$data['datas'] = $this->user->reformat_sql_to_form($data['datas']);

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		$data = $this->user->reformat_post_to_sql($data);

		// confirm password
		if($data['password'] != $data['confirm_password']){
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Password and Confirm Password must be same!');
			$this->db->trans_complete();
			redirect($this->redirect_url);
		}elseif($data['password'] != ''){
			$data['password'] = genpass($data['password']);
			unset($data['confirm_password']);
		}
		// end of confirm password

		if($this->user->insert($data)){
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

		$data = $this->user->reformat_post_to_sql($data);

		// confirm password
		if($data['password'] != '' AND ($data['password'] != $data['confirm_password'])){
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Password and Confirm Password must be same!');
			$this->db->trans_complete();
			redirect($this->redirect_url);
		}elseif($data['password'] != ''){
			$data['password'] = genpass($data['password']);
			unset($data['confirm_password']);
		}else{
			unset($data['password']);
			unset($data['confirm_password']);
		}
		// end of confirm password

		$st = $this->user->update($id, $data);
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

		if($this->user->delete($id)){
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Delete '.$this->title.' failed');
		}
		redirect($this->redirect_url);
	}

	public function datatable(){
		$uri = str_replace('/datatable', '', uri_string());
		$indexs = $this->user->get_dt_table_field();

		// if use join and 'as' in SELECT
		$dt_join = array();
		foreach ($indexs as $i => $index) {
			if($index == 'group_id'){
				$indexs[$i] = 'group.name as group_name';
				$dt_join[] = 'group';
			}elseif($index == 'id'){
				$indexs[$i] = 'user.id';
			}elseif($index == 'name'){
				$indexs[$i] = 'user.name';
			}
		}

		if(count($dt_join) > 0) $this->user->dt_join = $dt_join;

		$this->user->dt_indexs        = $indexs;// array('gn_id', 'gn_name', "gn_id");
		$this->user->dt_action_index  = (count($indexs) - 1);
		$this->user->dt_edit_action   = check_access_menu($uri.'/edit');
		$this->user->dt_delete_action = check_access_menu($uri.'/delete');
		$this->user->dt_url_action    = base_url_admin().$this->controller.'/';
		$this->user->dt_index_edit    = 'id';
		// $this->user->dt_where       = array("user_id" => $this->session->userdata('id'));

		echo $this->user->datatable();
	}

	public function print_excel(){
		$this->load->library('excel');
		$filename = 'Print Data '.$this->title;
		$table_field = $this->user->table_field;

		// if use join and 'as' in SELECT
		$indexs = array();
		foreach ($table_field as $i => $tf) {
			if($tf['in_print'] == true){
				$indexs[$i] = $tf['table_index'];
				// in this case i want to change group_id to show group.name in excel
				if($tf['table_index'] == 'group_id'){
					$indexs[$i] = 'group.name as group_name';
					$table_field[$i]['table_index'] = 'group_name';
				}elseif($tf['table_index'] == 'id'){
					$indexs[$i] = 'user.id';
					// $table_field[$i]['table_index'] = 'group_name';
				}elseif($tf['table_index'] == 'name'){
					$indexs[$i] = 'user.name';
					// $table_field[$i]['table_index'] = 'group_name';
				}
			}
		}
		$this->user->select(implode(', ', $indexs));
		foreach ($this->user->belongs_to as $table => $join) {
			$this->user->join($table);
		}
		// # end of // if use join and 'as' in SELECT
		
		$datas = $this->user->get_all();

		$objPHPExcel = new PHPExcel();

		// set properties
		$objPHPExcel->getProperties()->setCreator($this->session->userdata('site_title'));
		$objPHPExcel->getProperties()->setTitle($filename);
		// $objPHPExcel->getProperties()->setCreator("ThinkPHP")
		// 				->setLastModifiedBy("Daniel Schlichtholz")
		// 				->setTitle("Office 2007 XLSX Test Document")
		// 				->setSubject("Office 2007 XLSX Test Document")
		// 				->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
		// 				->setKeywords("office 2007 openxml php")
		// 				->setCategory("Test result file");
		
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$huruf = 'A';
		$row = 1;
		$count_cols = 0;
		foreach ($table_field as $tf) {
			if($tf['in_print'] == true){
				$objWorksheet->getCell($huruf.$row)->setValue($tf['name']);
				$huruf++;
				$count_cols++;
			}
		}
		$row++;
		
		// for date format
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

		foreach ($datas as $data) {
			$huruf = 'A';
			foreach ($table_field as $tf) {
				if($tf['in_print'] == true){
					$value = $data[$tf['table_index']];

					$objWorksheet->getCell($huruf.$row)->setValue($value);
					$objWorksheet->getColumnDimension($huruf)->setAutoSize(true);

					if($tf['type'] == 'date' or $tf['type'] == 'datepicker'){
						$objWorksheet->getStyle($huruf.$row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
						// $objWorksheet->getStyle($huruf.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
						// $objWorksheet->getStyle($huruf.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					}

					$huruf++;
				}
			}
			$row++;
		}

		// set border
		// set the borderline
		if($huruf == 'AA'){
			$huruf = 'Z';
		}elseif($huruf == 'AAA'){
			$huruf = 'ZZ';
		}elseif(strlen($huruf) == 2){
			$first_huruf = substr($huruf, 0, 1);
			$last_huruf = substr($huruf, 1, 1);
			if($last_huruf == 'A'){
				$first_huruf = chr(ord($first_huruf) - 1);
				$last_huruf = 'Z';
			}else{
				$last_huruf = chr(ord($last_huruf) - 1);
			}
			$huruf = $first_huruf.$last_huruf;
		}else{
			$huruf = chr(ord($huruf) - 1);
		}
		$row--;
		$objWorksheet->getStyle("A1:".$huruf.$row)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						// 'color' => array('rgb' => 'DDDDDD')
					)
				)
			)
		);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
		$objWriter->save('php://output');
	}
}
?>