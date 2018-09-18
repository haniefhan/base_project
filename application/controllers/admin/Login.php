<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once getcwd() ."/application/libraries/securimage/securimage.php";

class Login extends Public_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin');
		$this->lang->load('login', $this->session->userdata('lang'));
		// var_dump($this->config->item('index_page')); // change all of index.php to this
	}

	public function index(){
		// for load and save to session template variable
		admin_template();
		if(login_check()){
			redirect(base_url_admin().'dashboard');
		}
		
		$data = array();
		$data['title'] 		= 'Login';
		$this->load->view($this->session->userdata('template_login'), $data);
	}

	public function signin(){
		$data = $this->input->post();
		$this->load->model('User_model', 'user');
		$user = $this->user->get_by(array('username' => $data['username']));
		
		// check user exist
		if($user != NULL){
			// check captcha
			$captcha = true;

			if($this->session->login_attempt > 1){
				$securimage = new securimage;
				$captcha = $securimage->check($this->input->post('captcha_code'));
			}

			if($captcha == true){
				if($user['password'] == genpass($data['password'])){
					$this->session->set_userdata('user_login', true);
					// user information
					foreach ($user as $field => $value) {
						if($field != 'password' && $field != 'create_date' && $field != 'create_by' && $field != 'update_date' && $field != 'update_by'){
							$this->session->set_userdata($field, $value);
						}
					}
					set_menu($user['group_id']);
					$this->session->set_userdata('login_attempt', 0);
				}else{
					$this->session->set_flashdata('notif_status', false);
					$this->session->set_flashdata('notif_msg', lang('User password missmatch'));
					$this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
				}
			}else{
				$this->session->set_flashdata('notif_status', false);
				$this->session->set_flashdata('notif_msg', lang('Captcha incorrect'));
				$this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
			}
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', lang('User not registered'));
			$this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
		}
		redirect(base_url_admin().'login');
	}

	public function signout(){
		$this->session->set_userdata('user_login', false);
		$this->session->sess_destroy();
		
		$this->session->set_flashdata('notif_status', true);
		$this->session->set_flashdata('notif_msg', "You're logout now.");
		redirect(base_url_admin().'login');
	}

	public function gen_captcha(){
		$img = new securimage;
		$img->text_color  = new Securimage_Color("#000000");
		$img->image_width = 137;
		$img->image_height = 80;
		$img->font_ratio = 0.3;
		return $img->show();
	}

	public function clear_session(){
		$this->session->sess_destroy();
	}
}
