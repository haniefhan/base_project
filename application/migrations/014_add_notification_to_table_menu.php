<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Notification_To_Table_Menu extends CI_Migration {

	public function up(){
		$data = array();

		$data = array(
			'id' => 10,
			'name' => "Notification",
			'url' => "notification",
			'icon' => "fa fa-envelope-o",
			'status' => 1,
			'order' => 99,
			'parent' => 0,
			'state' => "view",
			'access_manage' => '["view", "datatable", "read"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);

		$this->db->insert('menu', $data);

		$data = array();
		$data = array(
			'group_id' => 1,
			'menu_id' => 10,
			'access_grant' => '["view", "datatable", "read"]',
		);

		$this->db->insert('menugroup', $data);
	}

	public function down(){
		$this->db->delete('menugroup', array('menu_id' => 10));
		$this->db->delete('menu', array('id' => 10));
	}
}