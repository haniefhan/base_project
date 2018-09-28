<?php
class Theme extends Admin_Controller implements ControllerInterface{
	public function __construct(){
		parent::__construct();
		$this->load->model("Template_model", 'theme');
		$this->title = 'Theme';
		$this->controller = 'theme';
		$this->redirect_url = base_url_admin().'theme';
	}

	function index(){
		$type 	= $this->input->get('type');
		if($type == null){
			$data['title']		= $this->title;
			$data['content']	= 'content/theme/index';
			$data['admin'] 		= $this->theme->get_many_by(array('type' => 'admin'));
			$data['public'] 	= $this->theme->get_many_by(array('type' => 'public'));
			$this->template($data);
		}else{
			$id 	= $this->input->get('id');
			if($id != ''){
				$this->breadcrumb[] = array('url' => $this->redirect_url.'/index?type=examples&id='.$id, 'name' => 'Dokumentasi');
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
		$type = $this->input->get('type');
		$theme = $this->theme->get($id);
		$this->load->model("Setting_model", 'setting');

		$template_color = NULL;
		if($type == 'public'){
			if($theme['color'] != ''){
				$arr_color = json_decode($theme['color'], true);
				$template_color = $arr_color[0]['value'];
			}

			$data[] = array('name' => 'template', 'value' => $theme['name']);
			$data[] = array('name' => 'template_color', 'value' => $template_color);
		}

		if($type == 'admin'){
			if($theme['color'] != ''){
				$arr_color = json_decode($theme['color'], true);
				$template_color = $arr_color[0]['value'];
			}

			$data[] = array('name' => 'template_admin', 'value' => $theme['name']);
			$data[] = array('name' => 'template_admin_color', 'value' => $template_color);
		}

		if($this->setting->update_batch($data, 'name')){
			if($type == 'public'){
				$this->session->set_userdata('template', $theme['url'].'index');
				$this->session->set_userdata('template_use', $theme['url']);
				$this->session->set_userdata('template_name', $theme['name']);
				$this->session->set_userdata('template_color', $template_color);
			}

			if($type == 'admin'){
				$this->session->set_userdata('template_admin', $theme['url'].'index');
				$this->session->set_userdata('template_admin_use', $theme['url']);
				$this->session->set_userdata('template_login', $theme['url'].'login');
				$this->session->set_userdata('template_admin_color', $template_color);
			}

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

	public function change_color(){
		$value = $this->input->get('value');
		$type = $this->input->get('type');
		$this->load->model("Setting_model", 'setting');

		$template_type = 'template_admin_color';
		if($type == 'public'){
			$template_type = 'template_color';
		}


		if($this->setting->update_by(array('name' => $template_type), array('value' => $value))){
			$this->session->set_userdata($template_type, $value);

			$this->session->set_flashdata('notif_status', true);
			$this->session->set_flashdata('notif_msg', 'Change color success.');
		}else{
			$this->session->set_flashdata('notif_status', false);
			$this->session->set_flashdata('notif_msg', 'Change color failed.');
		}

		redirect($this->redirect_url);
	}
}
?>