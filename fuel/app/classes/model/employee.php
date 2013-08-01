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
		//DB::expr('CONCAT(first, " ", last) as `name`')
		$results = DB::select('id', DB::expr('CONCAT(first, " ", last) as `name`'))->from('employees')->order_by('name')->execute()->as_array();
		//return $options->as_array();

		$options = array();
		foreach($results as $result){
			$options[$result['id']] = $result['name']; 
		}
		
		return $options;

	}

	protected static $_has_many = array(
		'employeeEventLink' => array(
			'key_from' => 'id',
			'model_to' => 'Model_EmployeeEventLink',
			'key_to' => 'employeeID',
			'cascade_delete' => true,
		)
	);

}
