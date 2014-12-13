<?php
class Controller_Admin_Result extends Controller_Admin
{

	public function action_index()
	{
		$data['results'] = Model_Result::find('all');
		$this->template->title = "Results";
		$this->template->content = View::forge('admin/result/index', $data);

	}

	public function action_view($id = null)
	{
		$data['result'] = Model_Result::find($id);

		$this->template->title = "Result";
		$this->template->content = View::forge('admin/result/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Result::validate('create');

			if ($val->run())
			{
				$result = Model_Result::forge(array(
					'queue_id' => Input::post('queue_id'),
					'json' => Input::post('json'),
				));

				if ($result and $result->save())
				{
					Session::set_flash('success', e('Added result #'.$result->id.'.'));

					Response::redirect('admin/result');
				}

				else
				{
					Session::set_flash('error', e('Could not save result.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Results";
		$this->template->content = View::forge('admin/result/create');

	}

	public function action_edit($id = null)
	{
		$result = Model_Result::find($id);
		$val = Model_Result::validate('edit');

		if ($val->run())
		{
			$result->queue_id = Input::post('queue_id');
			$result->json = Input::post('json');

			if ($result->save())
			{
				Session::set_flash('success', e('Updated result #' . $id));

				Response::redirect('admin/result');
			}

			else
			{
				Session::set_flash('error', e('Could not update result #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$result->queue_id = $val->validated('queue_id');
				$result->json = $val->validated('json');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('result', $result, false);
		}

		$this->template->title = "Results";
		$this->template->content = View::forge('admin/result/edit');

	}

	public function action_delete($id = null)
	{
		if ($result = Model_Result::find($id))
		{
			$result->delete();

			Session::set_flash('success', e('Deleted result #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete result #'.$id));
		}

		Response::redirect('admin/result');

	}

}
