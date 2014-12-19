<?php
class Controller_Main extends \Controller_Base
{
	public function action_index()
	{
		$view = \View::forge('main/index');

		$this->template->css = array(
            'joint.min.css',
            'joint.shapes.imgbox.css',
            'joint.shapes.iconbox.css',
            'bootstrap.min.css',
            'style.css'
        );
		$this->template->js = array(
			'bootstrap.js',
            'joint.min.js',
            'joint.shapes.devs.min.js',
            'joint.shapes.erd.min.js',
            'joint.shapes.imgbox.js',
            'joint.shapes.iconbox.js',
            'joint.shapes.devs.mlmodel.js',
            'main.js'
        );
		$this->template->content = $view;

//		return \Response::forge($view);
	}


	public function action_login()
	{
		// Already logged in
		Auth::check() and Response::redirect('main');

		$val = Validation::forge();

		if (Input::method() == 'POST')
		{
			$val->add('email', 'Email or Username')
			    ->add_rule('required');
			$val->add('password', 'Password')
			    ->add_rule('required');

			if ($val->run())
			{
				$auth = Auth::instance();

				// check the credentials. This assumes that you have the previous table created
				if (Auth::check() or $auth->login(Input::post('email'), Input::post('password')))
				{
					// credentials ok, go right in
					if (Config::get('auth.driver', 'Simpleauth') == 'Ormauth')
					{
						$current_user = Model\Auth_User::find_by_username(Auth::get_screen_name());
					}
					else
					{
						$current_user = Model_User::find_by_username(Auth::get_screen_name());
					}
					Session::set_flash('success', e('Welcome, '.$current_user->username));
					Response::redirect('main');
				}
				else
				{
					$this->template->set_global('login_error', 'Fail');
				}
			}
		}

		$this->template->title = 'Login';
		$this->template->content = View::forge('admin/login', array('val' => $val), false);
	}

	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_logout()
	{
		Auth::logout();
		Response::redirect('main');
	}
}