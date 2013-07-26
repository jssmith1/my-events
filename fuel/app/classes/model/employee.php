<?php
use Orm\Model;

class Model_Employee extends Model
{
	protected static $_properties = array(
		'id',
		'first',
		'last',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('first', 'First', 'required|max_length[255]');
		$val->add_field('last', 'Last', 'required|max_length[255]');

		return $val;
	}

	public static function getOptions(){
		$employees = Model_Employee::find('all');
		foreach ($employees as $employee){
			$ids[] = $employee->id;
			$names[] = $employee->first.' '.$employee->last;
		}
		$options = array_combine($ids, $names);
		unset($options[12]); //Move employee none to the front
		asort($options);
		$options = array('12' => 'None ') + $options;
		return $options;

	}

	protected static $_has_many = array(
		'employeeEventLink' => array(
			'key_from' => 'id',
			'model_to' => 'Model_employeeEventLink',
			'key_to' => 'employeeID',
			'cascade_delete' => true,
		)
	);

}
