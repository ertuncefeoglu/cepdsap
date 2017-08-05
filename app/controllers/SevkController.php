<?php

class SevkController extends \BaseController {

	// Bu metodu Basecontroller'a taşıyabilir miyiz?
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

		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return Response::json([
            'create' => 'create metodu çalıştı'
        ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$val = Input::json()->all();

		$sevkler = Input::json('sevkler');

		foreach ($sevkler as $key => $value) {
			# code...
			$tmp_sonuc['malzeme_kodu']=ltrim($value['malzeme_kodu'], '0');
			$tmp_sonuc['malzeme_adi']=$value['malzeme_adi'];
			$tmp_sonuc['irsaliye_miktari']=$value['sevk_miktari'];
			$sonuc[] = $tmp_sonuc;

		}

		return Response::json([
            'sonuc' => $sonuc
        ]);

		return Response::json([
            'store' => 'store metodu çalıştı'
        ]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$sevkler = array(
					array(
						'malzeme_kodu' => '000000000501000121',
						'malzeme_adi' => 'SABAH',
						'sevk_miktari' => 10
					),
					array(
						'malzeme_kodu' => '000000000501000126',
						'malzeme_adi' => 'TAKVIM',
						'sevk_miktari' => 8
					),
					array(
						'malzeme_kodu' => '000000000501000125',
						'malzeme_adi' => 'FOTOMAC',
						'sevk_miktari' => 5
					),
					array(
						'malzeme_kodu' => '000000000502000224',
						'malzeme_adi' => 'COSMOPOLITAN',
						'sevk_miktari' => 0
					)
		);

		if ($id == '0000000000001556') {
			$tiraj = 'tiraj yok';
		}
		else if($id == '0000000000067434') {
			$tiraj = 'tiraj kaydedildi';
		}
		else if($id == '0000000000067434') {
			$tiraj = 'tiraj hazır';
		}

		return Response::json([
            'sevkler' => $sevkler
        ]);

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
		return Response::json([
            'edit' => 'edit metodu çalıştı'
        ]);
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
		return Response::json([
            'update' => 'update metodu çalıştı'
        ]);
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