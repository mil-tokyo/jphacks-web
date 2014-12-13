<?php
class Controller_Main extends \Controller
{
	public function action_index()
	{
		$view = \View::forge('main/index');

		return \Response::forge($view);
	}
}