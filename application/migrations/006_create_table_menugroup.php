<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Table_Menugroup extends CI_Migration {

	public function up(){
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
				),
			'menu_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
				),
			'access_grant' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			));
		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->add_key('menu_id', TRUE);
		$this->dbforge->create_table('menugroup', TRUE);
	}

	public function down(){
		$this->dbforge->drop_table('menugroup');
	}
}