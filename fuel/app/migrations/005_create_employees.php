<?php

namespace Fuel\Migrations;

class Create_employees
{
	public function up()
	{
		\DBUtil::create_table('employees', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'first' => array('constraint' => 255, 'type' => 'varchar'),
			'last' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('employees');
	}
} 	