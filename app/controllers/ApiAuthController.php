<?php

class ApiAuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        Auth::logout();

        return Response::json([
                'flash' => 'Sistemden çıkış gerçekleşti.'],
            200
        );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $credentials = array(
            'username' =>  Input::get('username'),
            'password' =>  Input::get('password'));

        if ( Auth::attempt($credentials) ) {

        		// token denemesi başlangıç
				$token_key = "apidsap";
				$token_body = array(
				
				    "expire" => 3600 ,
				    "dealer_code" => '0000700651',
				    "route_code" => '01'
				);

				$token = JWT::encode($token_body, $token_key);
				$decoded = JWT::decode($token, $token_key);

				/*
				print_r($decoded);
				*/

				/*
				 NOTE: This will now be an object instead of an associative array. To get
				 an associative array, you will need to cast it as such:
				*/

				$decoded_array = (array) $decoded;
				// token denemesi sonu
				return Response::json(
						[
						'token' => $token
						],
						202

					);

            return Response::json([
                    'user' => Auth::user()->toArray()],
                202
            );

        }else{
            return Response::json([
                    'flash' => 'Giriş denemesi başarısız oldu.'],
                401
            );
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}