<?php

namespace Fuel\Migrations;

class Add_association_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'association' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'association'

		));
	}
}