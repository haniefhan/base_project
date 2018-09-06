<?php
class Setting_model extends MY_Model {
	protected $_table 		= 'setting';
	protected $_primary_key = 'id';

	// observer
	public $_user_id = 0; // from session 
	public $before_create = array('create_mark');
	public $before_update = array('update_mark');

	public function extract_data(){
		$datas = $this->get_all();
		$ret = array();
		foreach ($datas as $i => $data) {
			$ret[$data['name']] = $data['value'];
		}
		return $ret;
	}
}
?>