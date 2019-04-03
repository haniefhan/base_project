<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_Setting extends CI_Migration {

	public function up(){
		$datas = array();
		$datas[] = array(
			'name' => "site_title",
			'value' => "Base Project",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "tagline",
			'value' => "Just Another Base Project",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "email",
			'value' => "haniefstudio@gmail.com",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "time_zone",
			'value' => "Asia/Jakarta",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "lang",
			'value' => "english",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "logo",
			'value' => "",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "template_admin",
			'value' => "adminlte",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "template",
			'value' => "adminlte",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "template_admin_color",
			'value' => "skin-blue",
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "template_color",
			'value' => NULL,
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);

		$this->db->insert_batch('setting', $datas);
	}

	public function down(){
		$this->db->truncate('setting');
	}
}