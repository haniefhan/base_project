<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once getcwd() ."/application/libraries/securimage/securimage.php";

class Login extends Public_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin');
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
					$this->session->set_flashdata('notif_msg', 'User & password missmatch');
					$this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
				}
			}else{
				$this->session->set_flashdata('notif_status', false);
				$this->session->set_flashdata('notif_msg', 'Captcha incorrect');
				$this->session->set_userdata('login_attempt', $this->session->userdata('login_attempt') + 1);
			}
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'User not registered');
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

	public function forgot_password(){
		$data = array();
		$data['title'] 		= 'Forgot Password';
		$data['state'] 		= 'forgot';
		$this->load->view($this->session->userdata('template_forgot'), $data);
	}

	public function reset_password(){
		$email = $this->input->post('email');

		$this->load->model('User_model', 'user');
		$data = $this->user->get_by(array('email' => $email));

		if(count($data) > 0){
			$password_reset = genpass('password_reset'.date('Y-m-d H:i:s'));
			$this->user->update($data['id'], array('password_reset' => $password_reset));

			$data['password_reset'] = $password_reset;
			$this->reset_email($data);

			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', "Password reset has been send to your email.");
		}else{
			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', "Password reset has been send to your email.");
		}
		redirect(base_url_admin().'login');
	}

	private function reset_email($data = array()){
		$email = $data['email'];
		$this->load->config('email');
		$this->load->library('email');

		$html = 'Pengguna '.$data['name'].'<br/><p>Silahkan klik link dibawah ini untuk melakukan reset password.</p><p><a href="'.base_url_admin().'login/change_password?code='.$data['password_reset'].'">'.$data['password_reset'].'</a></p>';

		$this->email->set_newline("\r\n");

		$this->email->from($this->config->item('email_from'), $this->session->userdata('site_title'));
		$this->email->to($email);

		$this->email->subject('['.$this->session->userdata('site_title').'] Reset Password');
		$this->email->message($html);

		$result = $this->email->send();
	}

	public function change_password(){
		$code = $this->input->get('code');

		$this->load->model('User_model', 'user');
		$data = $this->user->get_by(array('password_reset' => $code));
		if(count($data) > 0){
			$data = array();
			$data['title'] 		= 'Change Password';
			$data['state'] 		= 'change_password';
			$data['code'] 		= $code;
			$this->load->view($this->session->userdata('template_forgot'), $data);
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', "Forgot password not exist.");
			redirect(base_url_admin().'login');
		}
	}

	public function do_change_password(){
		$code = $this->input->post('code');
		$pswd = $this->input->post('password');

		$password = genpass($pswd);

		$this->load->model('User_model', 'user');
		$this->user->update_by(array('password_reset' => $code), array('password' => $password, 'password_reset' => NULL));

		$this->session->set_flashdata('notif_status', true);
		$this->session->set_flashdata('notif_msg', "Change password success.");
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
