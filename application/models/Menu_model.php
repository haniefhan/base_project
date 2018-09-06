<?php
class Menu_model extends MY_Model {
	protected $_table 		= 'menu';
	protected $_primary_key = 'id';

	public function menu_structured(){
		$res = $this->get_all();

		$tree = array();
		$child = array();
		foreach ($res as $i => $v) {
			if($v['parent'] != 0){
				unset($v['create_date']);
				unset($v['create_by']);
				unset($v['update_date']);
				unset($v['update_by']);

				$child[$v['parent']][$v['order']] = $v;
				unset($res[$i]);
			}
		}

		foreach ($res as $i => $v) {
			unset($v['create_date']);
			unset($v['create_by']);
			unset($v['update_date']);
			unset($v['update_by']);
			
			$tree[(int)$v['order']] = $v;
			if(isset($child[$v['id']])){
				$tree[$v['order']]['children'] = $child[$v['id']];
			}
		}
		ksort($tree);
		return $tree;
	}

	public function access_name(){
		return array('view', 'add', 'edit', 'delete');
	}
}
?>