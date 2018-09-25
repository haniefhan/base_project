<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model", 'user');
		$this->title = 'Profile';
		$this->controller = 'profile';
		$this->redirect_url = base_url_admin().'profile';
	}

	public function index(){
		$data = array();
		$data['title'] 		= $this->title;
		$data['controller']	= $this->controller;

		$data['datas'] 		= $this->user->get($this->session->userdata('id'));
		$data['content'] 	= 'content/profile';

		$this->template($data);
	}

	public function update(){
		$id 	= $this->session->userdata('id');
		$post 	= $this->input->post();

		$next = false;
		$msg  = '';
		if($post['old_password'] == '' && $post['password'] == '' && $post['repassword'] == ''){
			$next = true;
			unset($post['old_password']);
			unset($post['password']);
			unset($post['repassword']);
			$msg = 'Change Profile Success.';
		}else{
			// check old password
			$data = $this->user->get($id);
			if(genpass($post['old_password']) == $data['password']){
				if($post['password'] == '' or $post['repassword'] == ''){
					$msg = 'New Password and Repeat New Password cannot empty!';
				}
				elseif($post['password'] == $post['repassword']){
					$next = true;
					unset($post['old_password']);
					unset($post['repassword']);
					$post['password'] = genpass($post['password']);
					$msg = 'Change Profile Success.';
				}else{
					$msg = 'New Password and Repeat New Password not same!';
				}
			}else{
				$msg = 'Wrong Old Password!';
			}
		}

		if($next == true){
			if($this->user->update($id, $post)){
				$this->session->set_flashdata('notif_status', true);
				$this->session->set_flashdata('notif_msg', $msg);
			}else{
				$this->session->set_flashdata('notif_status', false);
				$this->session->set_flashdata('notif_msg', $msg);
			}
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', $msg);
		}

		redirect($this->redirect_url);
	}
	
	public function add(){}
	public function edit(){}
	public function insert(){}
	public function delete(){}
}
