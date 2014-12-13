<?php
class Model_Result extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'queue_id',
		'json',
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
	
	protected static $_belongs_to = array(
		'queue' => array(
			'key_from' => 'queue_id',
			'model_to' => 'Model_Queue',
			'key_to' => 'id',
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('queue_id', 'Queue Id', 'required|valid_string[numeric]');
		$val->add_field('json', 'Json', 'required');

		return $val;
	}

}
