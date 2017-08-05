<?php


class RestController extends BaseController {

	public $restful = true;

	public function __construct() {
		throw new Exception('Bu sınıf kullanım dışıdır!');
	}

	public function doLogin()
	{
		// process the form
		$rules = array(
			'username' => 'required',
			'password' => 'required|alphaNum|min:3'
		);

		$userdata = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
			);

		$validator = Validator::make(Input::all(), $rules);
		
		$validator = Validator::make($userdata, $rules);
		
		if ($validator->fails())
		{
			return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			if (Auth::attempt($userdata)) {
				return array('success');
			} else {
				return array('fail');
			}
		}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return array('logged out'); // redirect the user to the login screen
	}
}