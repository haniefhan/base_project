<?php
class Menugroup_model extends MY_Model {
	protected $_table 		= 'menugroup';
	protected $primary_key 	= 'group_id';

	public function menugroup_structured($id = 0){
		$d = $this->get_many($id);
		$ret = array();

		foreach ($d as $i => $v) {
			$ret[$v['menu_id']] = $v;
		}

		return $ret;
	}
}
?>