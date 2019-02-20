<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Table_Menu extends CI_Migration {

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
			'icon' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'status' => array(
				'type' => 'TINYINT',
				'constraint' => 4,
				'null' => FALSE,
				'default' => 0
				),
			'order' => array(
				'type' => 'TINYINT',
				'constraint' => 4,
				'null' => TRUE
				),
			'parent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => 0
				),
			'state' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				'default' => 'view'
				),
			'access_manage' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
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
		$this->dbforge->create_table('menu', TRUE);
	}

	public function down(){
		$this->dbforge->drop_table('menu');
	}
}