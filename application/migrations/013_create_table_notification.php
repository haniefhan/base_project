<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Table_Notification extends CI_Migration {

	public function up(){
		$this->dbforge->add_field(array(
			'ntf_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
				'null' => FALSE
				),
			'ntf_title' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'ntf_content' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			// 'ntf_icon' => array(
			// 	'type' => 'VARCHAR',
			// 	'constraint' => 255,
			// 	'null' => TRUE
			// 	),
			'ntf_type' => array(
				'type' => 'TINYINT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => 1 // 1 : add, 2 : edit, 3 : delete
				),
			'ntf_url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
				),
			'ntf_read' => array(
				'type' => 'TINYINT',
				'constraint' => 4,
				'null' => TRUE,
				'default' => 0 // 0 : unread, 1 : read
				),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				),
			'menu_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE
				),
			));
		$this->dbforge->add_key('ntf_id', TRUE);
		$this->dbforge->create_table('notification', TRUE);
	}

	public function down(){
		$this->dbforge->drop_table('notification');
	}
}