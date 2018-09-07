<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		redirect(site_url().'/admin/login');
	}
}
