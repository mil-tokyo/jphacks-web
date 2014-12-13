<?php
class Controller_Admin_Queue extends Controller_Admin
{

	public function action_index()
	{
		$data['queues'] = Model_Queue::find('all');
		$this->template->title = "Queues";
		$this->template->content = View::forge('admin/queue/index', $data);

	}

	public function action_view($id = null)
	{
		$data['queue'] = Model_Queue::find($id);

		$this->template->title = "Queue";
		$this->template->content = View::forge('admin/queue/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Queue::validate('create');

			if ($val->run())
			{
				$queue = Model_Queue::forge(array(
					'user_id' => Input::post('user_id'),
					'state' => Input::post('state'),
					'started_at' => Input::post('started_at'),
				));

				if ($queue and $queue->save())
				{
					Session::set_flash('success', e('Added queue #'.$queue->id.'.'));

					Response::redirect('admin/queue');
				}

				else
				{
					Session::set_flash('error', e('Could not save queue.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Queues";
		$this->template->content = View::forge('admin/queue/create');

	}

	public function action_edit($id = null)
	{
		$queue = Model_Queue::find($id);
		$val = Model_Queue::validate('edit');

		if ($val->run())
		{
			$queue->user_id = Input::post('user_id');
			$queue->state = Input::post('state');
			$queue->started_at = Input::post('started_at');

			if ($queue->save())
			{
				Session::set_flash('success', e('Updated queue #' . $id));

				Response::redirect('admin/queue');
			}

			else
			{
				Session::set_flash('error', e('Could not update queue #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$queue->user_id = $val->validated('user_id');
				$queue->state = $val->validated('state');
				$queue->started_at = $val->validated('started_at');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('queue', $queue, false);
		}

		$this->template->title = "Queues";
		$this->template->content = View::forge('admin/queue/edit');

	}

	public function action_delete($id = null)
	{
		if ($queue = Model_Queue::find($id))
		{
			$queue->delete();

			Session::set_flash('success', e('Deleted queue #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete queue #'.$id));
		}

		Response::redirect('admin/queue');

	}

}
