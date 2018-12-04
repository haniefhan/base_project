<?php
class Menu_model extends MY_Model {
	protected $_table 		= 'menu';
	public $primary_key = 'id';

	public $belongs_to = array(
		'menu' => array('from_column' => 'parent', 'to_column' => 'id'),
		'menugroup' => array('from_column' => 'id', 'to_column' => 'menu_id'),
	);

	public $before_create = array('create_mark');
	public $before_update = array('update_mark');

	public $table_field = array(
		array(
			// table param
			'name' 			=> 'No',
			'table_index'	=> 'id',
			'style' 		=> 'width:15px;',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'hidden', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Name',
			'table_index'	=> 'name',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'URL',
			'table_index'	=> 'url',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Icon',
			'table_index'	=> 'icon',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Status',
			'table_index'	=> 'status',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select-simple', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> array(1 => 'Active', 0 => 'Inactive'),
			'required' 		=> true,
			'maxlength' 	=> 1,
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Order',
			'table_index'	=> 'order',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'numeric', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> 1,
			'required' 		=> true,
			'maxlength' 	=> 2,
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Parent',
			'table_index'	=> 'parent',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> array('Menu_model', 'id', 'name', array()),
			'required' 		=> false,
			'maxlength' 	=> 2,
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Access Manage',
			'table_index'	=> 'access_manage',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'text', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> 255,
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Action',
			'table_index'	=> 'id',
			'style' 		=> '', // 'width:15%;',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'hidden', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> false,
		),
	);

	public function get_children($parent_id = 0, $group_id = 0){
		$parent = $parent_id;

		$where = array('status' => 1, 'parent' => $parent_id);
		$this->order_by('order', 'ASC');
		if($group_id != 0) {
			$this->join('menugroup');
			$where['group_id'] = $group_id;
		}
		$datas = $this->get_many_by($where);

		$tree = array();
		foreach ($datas as $i => $data) {
			unset($datas[$i]['create_date']);
			unset($datas[$i]['create_by']);
			unset($datas[$i]['update_date']);
			unset($datas[$i]['update_by']);

			$tree[$data['order']] = $datas[$i];
			$tree[$data['order']]['children'] = $this->get_children($data['id'], $group_id);
		}

		ksort($tree);
		return $tree;
	}

	public function menu_structured($group_id = 0){
		/*$res = $this->get_many_by(array('status' => 1));

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
				ksort($child[$v['parent']], SORT_NUMERIC);
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
		return $tree;*/
		$where = array('status' => 1, 'parent' => 0);
		$this->order_by('order', 'ASC');
		if($group_id != 0) {
			$this->join('menugroup');
			$where['group_id'] = $group_id;
		}
		$datas = $this->get_many_by($where);

		$tree = array();
		foreach ($datas as $i => $data) {
			unset($datas[$i]['create_date']);
			unset($datas[$i]['create_by']);
			unset($datas[$i]['update_date']);
			unset($datas[$i]['update_by']);

			$tree[$data['order']] = $datas[$i];
			$tree[$data['order']]['children'] = $this->get_children($data['id'], $group_id);
		}

		ksort($tree);		
		return $tree;
	}

	public function access_name(){
		// return array('view', 'add', 'edit', 'delete');
		return array('view', 'datatable', 'add', 'insert', 'edit', 'update', 'delete');
	}

	public function all_access_name(){
		$ret = array();
		$this->select('access_manage');
		foreach ($this->get_all() as $menu) {
			foreach (json_decode($menu['access_manage'], true) as $mng) {
				if(!in_array($mng, $ret)) $ret[] = $mng;
			}
		}
		return $ret;
	}

	public function populate_select($index_field = '', $value_field = '', $where = array(), $join = array()){
	    $ret = array();
	    $menu2 = array();
	    $where1 = $where;
	    $where1['parent !='] = 0;

	    $select = array();
	    $select[] = $index_field;
	    $select[] = 'parent';
	    if(is_array($value_field)){
	        foreach ($value_field as $vf) {
	            $select[] = $vf;
	        }
	    }else{
	        $select[] = $value_field;
	    }
	    $this->select(implode(', ', $select));
	    if(count($join) > 0){
	        foreach ($join as $j) {
	            $this->join($j);   
	        }
	    }
	    $this->order_by('order', 'ASC');

	    foreach ($this->get_many_by($where1) as $data) {
	        if(is_array($value_field)){
	            $menu2[$data['parent']][$data['id']] = '  -- ';
	            foreach ($value_field as $vf) {
	                if($menu2[$data['parent']][$data['id']] != '') $menu2[$data['parent']][$data['id']] .= ' - ';
	                $menu2[$data['parent']][$data['id']] .= $data[$vf];
	            }
	        }else{
	            $menu2[$data['parent']][$data['id']] = '  -- '.$data[$value_field];
	        }
	    }

	    $this->select(implode(', ', $select));
	    if(count($join) > 0){
	        foreach ($join as $j) {
	            $this->join($j);   
	        }
	    }
	    $this->order_by('order', 'ASC');
	    $where['parent'] = 0;

	    foreach ($this->get_many_by($where) as $data) {
	        if(is_array($value_field)){
	            $ret[$data[$index_field]] = '';
	            foreach ($value_field as $vf) {
	                if($ret[$data[$index_field]] != '') $ret[$data[$index_field]] .= ' - ';
	                $ret[$data[$index_field]] .= $data[$vf];
	            }
	        }else{
	            $ret[$data[$index_field]] = $data[$value_field];
	        }

	        if(isset($menu2[$data[$index_field]])){
	        	foreach ($menu2[$data[$index_field]] as $index => $value) {
	        		$ret[$index] = $value;
	        	}
	        }
	    }

	    return $ret;
	}
}
?>