<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Table_Template extends CI_Migration {

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
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'example' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'image' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'color' => array(
				'type' => 'TEXT',
				'null' => TRUE
				),
			));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('template', TRUE);
	}

	public function down(){
		$this->dbforge->drop_table('template');
	}
}