<?php
class Controller_Api extends \Controller_Rest
{
	public function post_request()
	{
		$json = \Input::post('structure');
		if ( ! json_decode($json)) {
			$this->response(array('stat' => 0));
			return;
		}

		$structure = \Model_Structure::forge();
		$structure->set('json', $json);

		$queue = \Model_Queue::forge();
		$queue->structure = $structure;

		$queue->save();

		$this->response(array('stat' => 1));
	}

	public function get_result()
	{
		// mock
		$result = array(
			array(
				'type' => 'visualize',
				'name' => 'vis1',
				'img' => 'test.png'
			)
		);

		$this->response($result);
	}
}