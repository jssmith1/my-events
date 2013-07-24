<?php

class Model_EmployeeEventLink extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'employeeID',
		'eventID',
		'role',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'employeeEventLinks';

	protected static $_belongs_to = array(
		'employee' => array(
			'key_from' => 'employeeID',
			'model_to' => 'Model_Employee',
			'key_to' => 'id',
		//	'cascade_delete' => true
		),
		'event' => array(
			'key_from' => 'eventID',
			'model_to' => 'Model_Event',
			'key_to' => 'id',
		//	'cascade_delete' => true
		),
	);

}
