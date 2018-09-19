<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxdata extends Public_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function get_data($model = '', $index_field = '', $index_value = ''){
		if (!$this->input->is_ajax_request()) {
			redirect(base_url());
		}
		
		$arr = array();
		$arr['results'] = array();

		if(strpos($model, '_model') === false){
			$model = $model."_model";
		}

		$this->load->model(ucwords($model), 'select');
		$selects = $this->select->get_many_like(array($index_value => $this->input->get('q')));
		
		foreach ($selects as $sel) {
			$arr['results'][] = array('id' => $sel[$index_field], 'text' => $sel[$index_value]);
		}

		echo json_encode($arr);
	}
}
