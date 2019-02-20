<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Table_Group extends CI_Migration {

	public function up(){
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
				'null' => FALSE
				),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE
				),
			'create_by' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
				),
			'update_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE
				),
			'udpate_by' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
				),
			));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('group', TRUE);
	}

	public function down(){
		$this->dbforge->drop_table('group');
	}
}