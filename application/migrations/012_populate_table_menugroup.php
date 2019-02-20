<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_Menugroup extends CI_Migration {

	public function up(){
		$datas = array();

		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 1,
			'access_grant' => '["view"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 2,
			'access_grant' => '["view"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 3,
			'access_grant' => '["view","datatable","add","insert","edit","update","delete"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 4,
			'access_grant' => '["view","datatable","add","insert","edit","update","delete"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 5,
			'access_grant' => '["view","edit","update"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 6,
			'access_grant' => '["view"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 7,
			'access_grant' => '["view","edit","update"]',
		);
		$datas[] = array(
			'group_id' => 1,
			'menu_id' => 8,
			'access_grant' => '["view","edit","update","change_color"]',
		);

		$this->db->insert_batch('menugroup', $datas);
	}

	public function down(){
		$this->db->empty_table('menugroup');
	}
}