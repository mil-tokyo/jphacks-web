<?php
class Model_Queue extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'state',
		'started_at',
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

	protected static $_has_one = array(
		'structure' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Structure',
			'key_to' => 'queue_id',
		),
		'result' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Result',
			'key_to' => 'queue_id',
		),
	);

	const STATE_WAIT = 0;
	const STATE_RUNNING = 1;
	const STATE_FINISHED = 2;

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');
		$val->add_field('state', 'State', 'required');
		$val->add_field('started_at', 'Started At', 'required|valid_string[numeric]');

		return $val;
	}

	public static function forge($data = Array(), $new = true, $view = NULL, $cache = true)
	{
		$entity = parent::forge();
		$entity->set_state_wait();
		return $entity;
	}

	public function set_state_wait()
	{
		$this->set('state', static::STATE_WAIT);
	}
}
