<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_Group extends CI_Migration {

	public function up(){
		$datas = array();

		$datas[] = array(
			'name' => "Administrator",
			'create_date' => date('Y-m-d H:i:s'),
		);

		$this->db->insert_batch('group', $datas);
	}

	public function down(){
		$this->db->empty_table('group');
	}
}