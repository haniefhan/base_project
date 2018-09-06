<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller implements ControllerInterface{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data = array();
		$data['title'] 		= 'Dashboard';
		$data['content'] 	= 'content/dashboard';

		$this->template($data);
	}

	public function add(){}
	public function edit(){}
	public function insert(){}
	public function update(){}
	public function delete(){}
}
