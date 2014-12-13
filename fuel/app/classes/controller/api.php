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

		$this->response(array('stat' => 1, 'queue_id' => $queue->id));
	}

	public function get_result()
	{
		$queue_id = \Input::get('queue_id');
		// mock
		$result = array(
			'stat' => 1,
			'result' => array(
				array(
					'type' => 'Visualizer',
					'name' => 'visualizer1',
					'img' => 'imgs/test.jpg'
				),
				array(
					'type' => 'Visualizer',
					'name' => 'visualizer2',
					'img' => 'imgs/test2.jpg'
				)
			)
		);

		$this->response($result);
	}
}