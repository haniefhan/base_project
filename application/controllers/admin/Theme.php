<?php
class Theme extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Template_model", 'theme');
		$this->title = 'Theme';
		$this->redirect_url = base_url_admin().'theme';
		$this->lang->load('theme', $this->session->userdata('lang'));
	}

	function index(){
		$type 	= $this->input->get('type');
		if($type == null){
			$data['title']		= $this->title;
			$data['content']	= 'content/theme/index';
			$data['admin'] 		= $this->theme->get_many_by(array('type' => 'admin'));
			$this->template($data);
		}else{
			$id 	= $this->input->get('id');
			if($id != ''){
				$data['title']		= $this->title;
				$data['content']	= 'content/theme/examples';
				$data['data'] 		= $this->theme->get($id);
				$this->template($data);
			}else{
				redirect($this->redirect_url);
			}
		}
	}

	public function add(){}
	public function edit(){}
	public function insert(){}
	public function delete(){}

	function update(){
		$id = $this->input->get('id');
		$theme = $this->theme->get($id);
		$this->load->model("Setting_model", 'setting');
		$data[] = array('name' => 'template', 'value' => $theme['name']);

		if($this->setting->update_batch($data, 'name')){
			$this->session->set_userdata('template', $theme['url'].'index');
			$this->session->set_userdata('template_use', $theme['url']);
			$this->session->set_userdata('template_name', $theme['name']);

			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', ' success');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', ' failed');
		}
		redirect($this->redirect_url);
	}

	public function examples(){
		
	}
}
?>