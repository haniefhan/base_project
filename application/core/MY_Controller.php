<?php

class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->config->load('migration');
		if($this->config->item('migration_enabled')){
			$this->load->library('migration');
			if(!$this->migration->current()){
				show_error($this->migration->error_string());
			}
		}
	}
}

interface ControllerInterface{
	public function index();
	public function add();
	public function edit();
	public function insert();
	public function update();
	public function delete();
}

class Admin_Controller extends MY_Controller{
	public $title = '';
	public $controller = '';
	public $redirect_url = '';
	public $breadcrumb = array();

	public function __construct(){
		parent::__construct();
		$this->load->helper('general');
		$this->load->helper('admin');
		login_check(true);
		site_info();

		if(!in_array(uri_string(), $this->session->userdata('acc_grant'))){
			// access not granted
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', "You don't have permission to access the menu");
			redirect(base_url_admin().'dashboard');
		}
	}

	public function template($data = array()){
		if(!isset($data['script'])){
			$c = explode('/', $data['content']);
			$data['script'] = $this->session->userdata('template_admin_use').$c[0].'/'.$c[1].'/script';
		}
		$data['content'] 	= $this->session->userdata('template_admin_use').$data['content'];

		$data['breadcrumb'] = array();
		if($this->controller != '' && $this->title != ''){
			$data['breadcrumb'][] = array('url' => base_url_admin().$this->controller, 'name' => $this->title);
		}

		if(isset($data['state'])){
			$data['breadcrumb'][] = array('url' => current_url(), 'name' => $data['title']);
		}

		foreach ($this->breadcrumb as $bc) {
			$data['breadcrumb'][] = array('url' => $bc['url'], 'name' => $bc['name']);
		}

		$this->load->model('Notification_model', 'notification');
		$data['notification'] = $this->notification->get_notification();

		$this->load->view($this->session->userdata('template_admin'), $data);
	}
}

class Public_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('general');
		$this->load->helper('public');
		public_template();
		site_info();
	}

	public function template($data = array()){
		if(!isset($data['script'])){
			$c = explode('/', $data['content']);
			$data['script'] = $this->session->userdata('template_use').$c[0].'/'.$c[1].'/script';
		}
		$data['content'] 	= $this->session->userdata('template_use').$data['content'];
		$this->load->view($this->session->userdata('template'), $data);
	}
}
?>