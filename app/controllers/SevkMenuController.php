<?php

class SevkMenuController extends \BaseController {

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

		// sorguya dönüştürülecek
		$mekanlar = array(
						array(
							'mekan_kodu' => '0000000000001556',
							'mekan_adi'	=> 'YAYLA GIDA',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000067434',
							'mekan_adi'	=> 'İZMİR',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000068685',
							'mekan_adi'	=> 'KENTMAR MARKET',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000062017',
							'mekan_adi'	=> 'SGH DNR',
							'sevk' => false					
						),
						array(
							'mekan_kodu' => '0000000000059766',
							'mekan_adi'	=> 'ANADOLU TİCARET',
							'sevk' => false					
						),
						array(
							'mekan_kodu' => '0000000000060985',
							'mekan_adi'	=> 'GÖKYÜZÜ KİTAPEVİ',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000060984',
							'mekan_adi'	=> 'SALKIM GIDA',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000044989',
							'mekan_adi'	=> 'AYDIN MARKET',
							'sevk' => false					
						),
						array(
							'mekan_kodu' => '0000000000001765',
							'mekan_adi'	=> 'MEHMETCİK 1',
							'sevk' => true					
						),
						array(
							'mekan_kodu' => '0000000000001842',
							'mekan_adi'	=> 'MEHMETÇİK 2',
							'sevk' => false
						),
					);

        return Response::json([
            'mekanlar' => $mekanlar
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