<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function __construct() {
		throw new Exception('Bu sınıf kullanım dışıdır!');
	}

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function showLogin()
	{
		// show the form
		return View::make('login');
	}

	public function doLogin()
	{
		// process the form
		$rules = array(
			'email' => 'required|email',
			'password' => 'required|alphaNum|min:3'

		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			if (Auth::attempt($userdata)) {
				
				/*
					$DB2 = NewADOConnection('oci8');
					$DB2->Connect('10.2.254.75:1525', 'ZDS', 'dt32xc29', 'TMQ');
					//print_r($DB2);

					$rs2 = $DB2->Execute("select * from saptmq.zdsap_auth_users",array());
					while (!$rs2->EOF) {
					    print_r($rs2->fields);
					    $rs2->MoveNext();
					}
				*/
				return View::make('welcome');
			} else {
				return Redirect::to('login');
			}
		}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}
}
