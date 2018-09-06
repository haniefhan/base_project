<?php

if ( ! function_exists('public_template')){
	function public_template(){
		$CI = & get_instance();
		$CI->session->unset_userdata('template');
		if(!$CI->session->userdata('template')){
			// get from database
			$CI->load->model('Setting_model', 'setting');
			$temp = $CI->setting->get_by(array('name' => 'template'));

			$CI->load->model('Template_model', 'template');
			$template = $CI->template->get_by(array('name' => $temp['value']));

			$CI->session->set_userdata('template', $template['url'].'index');
			$CI->session->set_userdata('template_use', $template['url']);
			$CI->session->set_userdata('template_name', $template['name']);
		}
	}
}