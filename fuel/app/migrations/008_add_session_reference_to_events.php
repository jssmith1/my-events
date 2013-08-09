<?php

namespace Fuel\Migrations;

class Add_session_reference_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'session_reference' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'session_reference'

		));
	}
}