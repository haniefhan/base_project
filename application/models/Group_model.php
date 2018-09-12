<?php
class Group_model extends MY_Model {
	protected $_table 		= 'group';
	public $primary_key = 'id';

	public $table_field = array(
		0 => array(
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
		1 => array(
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
		2 => array(
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
}
?>