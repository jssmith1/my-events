<?php
use Orm\Model;
class Model_Event extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'description',
		'start',
		'end',
		'user_id',
		'created_at',
		'updated_at',
		'type',
		'issues',
		'association',
		'session_reference'
	);


	//Color map configured for 6 types of events	
	private static function get_color_map(){
		return array_combine(self::get_enum_values('type'), array('#00CC00',
																	'#0000FF',
																	'#FF0000',
																	'#660099',
																	'#00FFFF',
																	'#CCCCCC'));
	}					
										

	public static function get_type_color($type){
		//given a string representing an event's type return the color from the dictionary

		$search = self::get_color_map();
		if(array_key_exists($type, $search)){
			return $search[$type];
		}
		//Return a default color	
		return '#378006';

	}

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


	/**
	 * Fetches the enum values from a table and returns an array suitable for
	 * use with Form::select.
	 *
	 * @param    string    enum field name
	 *
	 * @return   array of allowed values
	 */
	public static function get_enum_values($field)
	{

		$column = DB::list_columns('events', $field);
		$options = array_values($column[$field]['options']);
		
		return $options;
	}


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('description', 'Description', 'required');
		$val->add_field('start', 'Start', 'required');
		$val->add_field('end', 'End', 'required');
		$val->add_field('type', 'Type', 'required');

		return $val;
	}

	protected static $_has_many = array(
		'employeeeventlink' => array(
			'key_from' => 'id',
			'model_to' => 'Model_EmployeeEventLink',
			'key_to' => 'eventID',
			'cascade_delete' => true,
		)
	);

}
