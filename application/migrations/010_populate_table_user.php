<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_User extends CI_Migration {

	public function up(){
		$datas = array();

		$datas[] = array(
			'name' => "Admin Hanief",
			'username' => "hanief",
			'password' => "90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",
			'password_reset' => "851fc24ccd48c3d248d22febe577a661bd359c73",
			'email' => "haniefstudio@gmail.com",
			'group_id' => 1,
			'create_date' => date('Y-m-d H:i:s'),
		);

		$this->db->insert_batch('user', $datas);
	}

	public function down(){
		$this->db->empty_table('user');
	}
}