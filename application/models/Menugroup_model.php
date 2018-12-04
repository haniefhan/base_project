<?php
class Menugroup_model extends MY_Model {
	protected $_table 		= 'menugroup';
	protected $primary_key 	= 'group_id';

	public function menugroup_structured($id = 0){
		$datas = $this->get_many($id);
		$ret = array();

		// foreach ($d as $i => $v) {
		// 	$ret[$v['menu_id']] = $v;
		// }
		
		foreach ($datas as $i => $data) {
			foreach (json_decode($data['access_grant'], true) as $menu) {
				$ret[$data['menu_id']][$menu] = 1;
			}
		}

		return $ret;
	}
}
?>