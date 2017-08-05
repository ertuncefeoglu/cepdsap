<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
	//$response->headers->set('X-CSRF-Token' , csrf_token()); //silinebilir
});


App::after(function($request, $response)
{
	//
	//$response->headers->set('X-CSRF-Token' , csrf_token()); //silinebilir
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// Route::when('*', 'csrf', array('post', 'put', 'delete'));

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

/* silinebilir
Route::filter('csrf', function($route, $request) {
	
	//var_dump(Input::all());
	var_dump($request->header('X-CSRF-Token'));
	$token = $request->header('X-CSRF-Token') ?: Input::get('_token');
	var_dump($token);
	die;
  if (Session::token() != $request->header('csrf-token')) {
  		return Redirect::to('login');
  	die;
    throw new Illuminate\Session\TokenMismatchException;
  }
});
*/

/* silinebilir
Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		//throw new Illuminate\Session\TokenMismatchException;
		return Redirect::to('login');
	}
});
*/


Route::filter('serviceCSRF',function(){
    if (Session::token() != Request::header('csrf_token')) {
        return Response::json([
            'message' => 'Yetkisiz erişim denemesi başarısız oldu!'
        ], 418);
    }
});

Route::filter('serviceAuth', function(){
    if(!Auth::check()){
        return Response::json([
            'flash' => 'Bu hizmete erişmek için kullanıcı girişi yapmanız gerekmektedir.'
        ], 401);
    }
});

Route::filter('allowOrigin', function($route, $request, $response)
{
	$response->header('access-control-allow-origin','*');
});