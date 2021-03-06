<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Common_model", 'common');
		$this->title = 'Common';
		$this->controller = 'common';
		$this->redirect_url = base_url_admin().'common';
	}

	function index(){
		$data = array();
		$data['title']		= $this->title;
		$data['controller']	= $this->controller;
		$data['datas']		= array();
		$data['datatable']	= base_url_admin().'common/datatable';

		// because it's simple index and form, use common form
		$data['table_field'] = $this->common->table_field;
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
		$data['content']	= 'content/common/form';
		$data['datas']      = $this->common->get(decrypt_id($id));

		$data['datas'] = $this->common->reformat_sql_to_form($data['datas']);

		$this->template($data);
	}

	function insert(){
		$this->db->trans_start();
		$data = $this->input->post();

		$data = $this->common->reformat_post_to_sql($data);

		// confirm password
		if($data['com_password'] != $data['confirm_password']){
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Password and Confirm Password must be same!');
			$this->db->trans_complete();
			redirect($this->redirect_url);
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
					$this->session->set_flashdata('notif_status', false);
					$this->session->set_flashdata('notif_msg', 'File upload failed, because file type not allowed. (Allowed file type : '.implode(', ', $filetype).')');
					$this->db->trans_complete();
					redirect($this->redirect_url);
				}
			}
		}
		// end of upload file

		if($this->common->insert($data)){
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

		if($this->common->delete($id)){
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

	public function print_excel(){
		$this->load->library('excel');
		$filename = 'Print Data '.$this->title;
		$table_field = $this->common->table_field;

		// if use join and 'as' in SELECT
		$indexs = array();
		foreach ($table_field as $i => $tf) {
			if($tf['in_print'] == true){
				$indexs[$i] = $tf['table_index'];
				// in this case i want to change group_id to show group.name in excel
				if($tf['table_index'] == 'group_id'){
					$indexs[$i] = 'group.name as group_name';
					$table_field[$i]['table_index'] = 'group_name';
				}
			}
		}
		$this->common->select(implode(', ', $indexs));
		foreach ($this->common->belongs_to as $table => $join) {
			$this->common->join($table);
		}
		// # end of // if use join and 'as' in SELECT
		
		$datas = $this->common->get_all();

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

	public function upload_csv(){
		$type = $this->input->get('type');
		if($type == 'upload'){

		}else{
			$filename = 'Format CSV '.$this->title.'.csv';
			$f = fopen('php://memory', 'w');
			
			$head_field = array();
			foreach ($this->common->table_field as $field) {
				if($field['in_form'] == true && $field['type'] != 'separator'){
					$head_field[] = $field['name'];
				}
			}
			fputcsv($f, $head_field);
			fseek($f, 0);

			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename="'.$filename.'";');
			fpassthru($f);
		}
	}

	public function upload_excel(){
		$type = $this->input->get('type');
		$this->load->library('excel');

		if($type == 'upload'){
			$file = $_FILES['file'];

			$objPHPExcel = new PHPExcel();
			
			try {
			    $file_path = $file['tmp_name'];

			    $inputFileType = PHPExcel_IOFactory::identify($file_path);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($file_path);
			} catch(Exception $e) {
			    die('Error loading file "'.pathinfo($file_path,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$objWorksheet = $objPHPExcel->getSheet(0);
			$firstRow = 2;
			$lastRow = $objWorksheet->getHighestRow();

			$datas = array();
			$no = 0;
			for ($row = $firstRow; $row <= $lastRow ; $row++) {
				$huruf = 'A';

				foreach ($this->common->table_field as $field) {
					if($field['in_form'] == true && $field['type'] != 'separator'){
						if($field['type'] == 'date'){
							$datas[$no][$field['table_index']] = $objWorksheet->getCell($huruf.$row)->getValue();
							if(is_numeric($datas[$no][$field['table_index']])){
								$date = $datas[$no][$field['table_index']] - 1;
								$datas[$no][$field['table_index']] = date('Y-m-d', strtotime('1899-12-31+'.$date.' days'));
							}elseif(is_string($datas[$no][$field['table_index']])){
								// need check if the date is correct for mysql_date
								// if not correct, then correct it
							}
						}else{
							$datas[$no][$field['table_index']] = $objWorksheet->getCell($huruf.$row)->getValue();
						}
						$huruf++;
					}
				}
				$no++;
			}

			if($this->input->post('reset_all')){
				$this->common->empty_table();
				$this->common->insert_batch($datas);
			}else{
				foreach ($datas as $data) {
					$this->common->insert_update_duplicate($this->common->primary_key, $data);
				}
			}

			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Update Insert '.$no.' data '.$this->title.' success');
			redirect($this->redirect_url);
		}else{
			$filename = 'Format Excel '.$this->title.'.xls';

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator($this->session->userdata('site_title'));
			$objPHPExcel->getProperties()->setTitle($filename);

			$objWorksheet = $objPHPExcel->getActiveSheet();
			
			$head_field = array();
			foreach ($this->common->table_field as $field) {
				if($field['in_form'] == true && $field['type'] != 'separator'){
					$head_field[] = $field['name'];
				}
			}

			$huruf = 'A';
			$row = 1;
			foreach ($head_field as $field) {
				$objWorksheet->getCell($huruf.$row)->setValue($field);
				$objWorksheet->getColumnDimension($huruf)->setAutoSize(true);
				$huruf++;
			}

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			$objWriter->save('php://output');
		}
	}
}
?>