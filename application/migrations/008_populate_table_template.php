<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_Table_Template extends CI_Migration {

	public function up(){
		$datas = array();
		$datas[] = array(
			'name' => "basic",
			'url' => "template/basic/",
			'type' => "admin",
			'example' => "bootstrap-3.3.7/docs/examples",
			'image' => NULL,
			'color' => NULL,
		);
		$datas[] = array(
			'name' => "gentelella",
			'url' => "template/gentelella/",
			'type' => "admin",
			'example' => "production",
			'image' => NULL,
			'color' => NULL,
		);
		$datas[] = array(
			'name' => "adminlte",
			'url' => "template/adminlte/",
			'type' => "admin",
			'example' => NULL,
			'image' => NULL,
			'color' => '[{"name":"Blue","color":"3C8DBC","value":"skin-blue"},{"name":"Black","color":"FFFFFF","value":"skin-black"},{"name":"Purple","color":"605CA8","value":"skin-purple"},{"name":"Green","color":"00A65A","value":"skin-green"},{"name":"Red","color":"DD4B39","value":"skin-red"},{"name":"Yellow","color":"F39C12","value":"skin-yellow"},{"name":"Blue Light","color":"3C8DBC","value":"skin-blue-light"},{"name":"Black Light","color":"FFFFFF","value":"skin-black-light"},{"name":"Purple Light","color":"605CA8","value":"skin-purple-light"},{"name":"Green Light","color":"00A65A","value":"skin-green-light"},{"name":"Red Light","color":"DD4B39","value":"skin-red-light"},{"name":"Yellow Light","color":"F39C12","value":"skin-yellow-light"}]',
		);

		$this->db->insert_batch('template', $datas);
	}

	public function down(){
		$this->db->truncate('template');
	}
}