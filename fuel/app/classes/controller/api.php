<?php
class Controller_Api extends \Controller_Rest
{
	public function post_request()
	{
		$received = \Input::post('structure');

		$res = array(
			'stat' => 1,
		);

		$this->response($res);
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