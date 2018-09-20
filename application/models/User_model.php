<?php
class User_model extends MY_Model {
	protected $_table 		= 'user';
	public $primary_key 	= 'id';

	// my style join
	public $belongs_to = array('group' => array('from_column' => 'group_id', 'to_column' => 'id'));

	// observer
	public $_user_id = 0; // from session 
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
			'name' 			=> 'Username',
			'table_index'	=> 'username',
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
			'name' 			=> 'Password',
			'table_index'	=> 'password',
			'style' 		=> '',
			'in_table' 		=> false,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'password', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> false,
		),
		array(
			// table param
			'name' 			=> 'Confirm Password',
			'table_index'	=> 'confirm_password',
			'style' 		=> '',
			'in_table' 		=> false,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'password', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> false,
		),
		array(
			// table param
			'name' 			=> 'Email',
			'table_index'	=> 'email',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'email', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Group',
			'table_index'	=> 'group_id',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select', // hidden, text, select, textarea, date, datepicker, numeric, money
			'value' 		=> array('Group_model', 'id', 'name', array()),
			'required' 		=> true,
			'maxlength' 	=> '255',
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
}
?>