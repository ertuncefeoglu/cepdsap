<?php

class MainMenuController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('serviceAuth');
        //$this->beforeFilter('serviceCSRF');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$menu = array(
				'title' => 'Sevk',
				'url' => 'sevk',
				'color' => 'red'
				);
		$menus[]=$menu;
		unset($menu);
		$menu = array(
				'title' => 'İrsaliye',
				'url' => 'irsaliye',
				'color' => 'turquoise'
				);
		$menus[]=$menu;
		unset($menu);
		$menu = array(
				'title' => 'Becayiş',
				'url' => 'becayis',
				'color' => 'yellow'
				);
		$menus[]=$menu;
		unset($menu);
		$menu = array(
				'title' => 'Sipariş',
				'url' => 'siparis',
				'color' => 'blue'
				);
		$menus[]=$menu;
		unset($menu);
		$menu = array(
				'title' => 'İade',
				'url' => 'iade',
				'color' => 'green'
				);
		$menus[]=$menu;
		unset($menu);
		$menu = array(
				'title' => 'Doküman',
				'url' => 'dokuman',
				'color' => 'brown'
				);
		$menus[]=$menu;
		unset($menu);

        return Response::json([
            'menus' => $menus
        ]);
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