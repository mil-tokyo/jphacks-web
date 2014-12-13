<?php
class Controller_Admin_Structure extends Controller_Admin
{

	public function action_index()
	{
		$data['structures'] = Model_Structure::find('all');
		$this->template->title = "Structures";
		$this->template->content = View::forge('admin/structure/index', $data);

	}

	public function action_view($id = null)
	{
		$data['structure'] = Model_Structure::find($id);

		$this->template->title = "Structure";
		$this->template->content = View::forge('admin/structure/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Structure::validate('create');

			if ($val->run())
			{
				$structure = Model_Structure::forge(array(
					'queue_id' => Input::post('queue_id'),
					'json' => Input::post('json'),
				));

				if ($structure and $structure->save())
				{
					Session::set_flash('success', e('Added structure #'.$structure->id.'.'));

					Response::redirect('admin/structure');
				}

				else
				{
					Session::set_flash('error', e('Could not save structure.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Structures";
		$this->template->content = View::forge('admin/structure/create');

	}

	public function action_edit($id = null)
	{
		$structure = Model_Structure::find($id);
		$val = Model_Structure::validate('edit');

		if ($val->run())
		{
			$structure->queue_id = Input::post('queue_id');
			$structure->json = Input::post('json');

			if ($structure->save())
			{
				Session::set_flash('success', e('Updated structure #' . $id));

				Response::redirect('admin/structure');
			}

			else
			{
				Session::set_flash('error', e('Could not update structure #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$structure->queue_id = $val->validated('queue_id');
				$structure->json = $val->validated('json');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('structure', $structure, false);
		}

		$this->template->title = "Structures";
		$this->template->content = View::forge('admin/structure/edit');

	}

	public function action_delete($id = null)
	{
		if ($structure = Model_Structure::find($id))
		{
			$structure->delete();

			Session::set_flash('success', e('Deleted structure #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete structure #'.$id));
		}

		Response::redirect('admin/structure');

	}

}
