<?php

namespace Fuel\Migrations;

class Create_employeeEventLinks
{
	public function up()
	{
		\DBUtil::create_table('employeeEventLinks', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'employeeID' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'eventID' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'role' => array('type' => 'enum',
							'constraint' => array(
												'techSupport',
												'assigned',
												'other')
							),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('employeeEventLinks');
	}
}