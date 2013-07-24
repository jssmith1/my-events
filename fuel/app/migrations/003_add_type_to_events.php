<?php

namespace Fuel\Migrations;

class Add_type_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'type' => array('type' => 'enum',
							'default' => 'other',
							'constraint' => array(
												'webinar',
												'liveBroadcast',
												'rebroadcast',
												'audiocast',
												'recordings',
												'other'),
							'null' => true)

		));
	

	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'type'

		));
	}
}