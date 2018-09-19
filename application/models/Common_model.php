<?php
class Common_model extends MY_Model {
	protected $_table 		= 'common';
	public $primary_key = 'com_id';

	public $belongs_to = array('group' => array('from_column' => 'group_id', 'to_column' => 'id'));

	public $table_field = array(
		array(
			// table param
			'name' 			=> 'No',
			'table_index'	=> 'com_id',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'hidden', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Name',
			'table_index'	=> 'com_name',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'text', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Password',
			'table_index'	=> 'com_password',
			'style' 		=> '',
			'in_table' 		=> false,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'password', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
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
			'type' 			=> 'password', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '255',
			// print param
			'in_print'		=> false,
		),
		array(
			// table param
			'name' 			=> 'Date 1',
			'table_index'	=> 'com_date1',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'date', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Date 2',
			'table_index'	=> 'com_date2',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'datepicker', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Numeric',
			'table_index'	=> 'com_numeric',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'numeric', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Money',
			'table_index'	=> 'com_money',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'money', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Text',
			'table_index'	=> 'com_text',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'textarea', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
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
			'type' 			=> 'select', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> array('Group_model', 'id', 'name', array()),
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
		),
		array(
			// table param
			'name' 			=> 'Year 1',
			'table_index'	=> 'com_year1',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'year', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
			'form-width'	=> 'half'
		),
		array(
			// table param
			'name' 			=> 'Year 2',
			'table_index'	=> 'com_year2',
			'style' 		=> '',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> true,
			'sortable' 		=> true,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'select-year', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> array('Common_model', 'now', 10, 'DESC'), // array-2 : 'now' or 2018
			'required' 		=> true,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> true,
			'form-width'	=> 'half'
		),
		array(
			// table param
			'name' 			=> 'File',
			'table_index'	=> 'file',
			'style' 		=> '',
			'in_table' 		=> false,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> true,
			'type' 			=> 'file', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> false,
			'form-width'	=> 'full'
		),
		array(
			// table param
			'name' 			=> 'Action',
			'table_index'	=> 'com_id',
			'style' 		=> '', // 'width:15%;',
			'in_table' 		=> true,
			// datatable param
			'searchable' 	=> false,
			'sortable' 		=> false,
			// form param
			'in_form' 		=> false,
			'type' 			=> 'hidden', // hidden, text, select, textarea, date, datepicker, numeric, money, email, select-year, year
			'value' 		=> '',
			'required' 		=> false,
			'maxlength' 	=> '',
			// print param
			'in_print'		=> false,
		),
	);
}
?>