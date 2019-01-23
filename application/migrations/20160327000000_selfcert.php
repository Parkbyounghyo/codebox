<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_selfcert extends CI_Migration {

        public function up()
        {


			// member_selfcert_history table
			$this->dbforge->add_field(array(
				'msh_id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					 'auto_increment' => TRUE,
				),
				'mem_id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'default' => '0',
				),
				'msh_company' => array(
					'type' => 'VARCHAR',
					'constraint' => '255',
					'default' => '',
				),
				'msh_certtype' => array(
					'type' => 'VARCHAR',
					'constraint' => '255',
					'default' => '',
				),
				'msh_cert_key' => array(
					'type' => 'VARCHAR',
					'constraint' => '255',
					'default' => '',
				),
				'msh_datetime' => array(
					'type' => 'DATETIME',
                    'null' => true,
				),
				'msh_ip' => array(
					'type' => 'VARCHAR',
					'constraint' => '50',
					'default' => '',
				),
			));
            $this->dbforge->add_key('msh_id', TRUE);
            $this->dbforge->add_key('mem_id');
            $this->dbforge->create_table('member_selfcert_history');					
		}

        public function down()
        {
            $this->dbforge->drop_table('member_selfcert_history');
		}
}