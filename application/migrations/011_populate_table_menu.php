<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_Menu extends CI_Migration {

	public function up(){
		$datas = array();

		$datas[] = array(
			'name' => "Dashboard",
			'url' => "dashboard",
			'icon' => "fa fa-dashboard",
			'status' => 1,
			'order' => 1,
			'parent' => 0,
			'state' => "view",
			'access_manage' => '["view"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Access Management",
			'url' => "#",
			'icon' => "fa fa-users",
			'status' => 1,
			'order' => 100,
			'parent' => 0,
			'state' => "view",
			'access_manage' => '["view"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "User",
			'url' => "user",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 1,
			'parent' => 2,
			'state' => "view",
			'access_manage' => '["view","datatable","add","insert","edit","update","delete"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Group",
			'url' => "group",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 2,
			'parent' => 2,
			'state' => "view",
			'access_manage' => '["view","datatable","add","insert","edit","update","delete"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Menu",
			'url' => "menu",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 3,
			'parent' => 2,
			'state' => "view",
			'access_manage' => '["view","datatable","add","insert","edit","update","delete"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Access Right",
			'url' => "access",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 4,
			'parent' => 2,
			'state' => "view",
			'access_manage' => '["view","edit","update"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Setting",
			'url' => "#",
			'icon' => "fa fa-gear",
			'status' => 1,
			'order' => 101,
			'parent' => 0,
			'state' => "view",
			'access_manage' => '["view"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "General",
			'url' => "general",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 1,
			'parent' => 7,
			'state' => "view",
			'access_manage' => '["view","edit","update"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);
		$datas[] = array(
			'name' => "Theme",
			'url' => "theme",
			'icon' => "fa fa-circle-o",
			'status' => 1,
			'order' => 2,
			'parent' => 7,
			'state' => "view",
			'access_manage' => '["view","edit","update","change_color"]',
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' => 1,
		);

		$this->db->insert_batch('menu', $datas);
	}

	public function down(){
		$this->db->truncate('menu');
	}
}