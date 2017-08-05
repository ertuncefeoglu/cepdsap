<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
* Deneysel default route
* Proje canlıya alınırken silinecek
* - Ertunç 26.11.2014
*/

/*
Route::get('/', function()
{

	$dbgbr = false; // debugbar ekstra veri göndererek test etmek için

	$mysql = false; // adodb üzerinden mysql bağlantısını test etmek için
	$oracle = false; // adodb üzerinden oracle-oci8 bağlantısını test etmek için
	$eloquent_oracle = false; // laravel oci paketi üzerinden oracle-oci8 bağlantısını test etmek için
	$eloquent_mysql = false; // laravel oci paketi üzerinden oracle-oci8 bağlantısını test etmek için

	$usertest = false;
	$basemodel = false;

	if ($dbgbr) {

		//Debugbar::info($res);
		//Debugbar::info($object);

		Debugbar::error("Error!");
		Debugbar::warning('Watch out..');
		Debugbar::addMessage('Another message', 'mylabel');

		return View::make('hello');
	}
		
	if ($eloquent_oracle) {
		$res = DB::select('select * from saptmq.zdsap_auth_users where kullanici_adi = \'ertunc\'');
		print_r($res);
	}

	if ($eloquent_mysql) {
		$rs = DB::select('select * from users');
		print_r($rs);
	}

	if ($mysql) {
		$DB = NewADOConnection('mysql');
		$DB->Connect('localhost', 'root', '3900878', 'laravel');
		print_r($DB);

		$rs = $DB->Execute("select * from users where username=?",array('ertuncefeoglu'));
		while (!$rs->EOF) {
		   	print_r($rs->fields);
		    $rs->MoveNext();
		}
	}

	if ($oracle) {
		$DB2 = NewADOConnection('oci8');
		$DB2->Connect('10.2.254.75:1525', 'ZDS', 'dt32xc29', 'TMQ');
		//print_r($DB2);

		$rs2 = $DB2->Execute("select * from saptmq.zdsap_auth_users",array());
		while (!$rs2->EOF) {
		    print_r($rs2->fields);
		    $rs2->MoveNext();
		}	
	}


	if ($usertest) {
		$dbconn = ApiDsap\DB\myDBConnection::connect();
		//print_r($dbconn);
		$rs2 = $dbconn->Execute("select * from saptmq.zdsap_auth_users",array());
			while (!$rs2->EOF) {
			    print($rs2->fields['KULLANICI_ID']);
			    print(" - ");
			    print($rs2->fields['KULLANICI_ADI']);
			    print(" - ");
			    print($rs2->fields['SIFRE']);
			    print_r("<br>");
			    $rs2->MoveNext();
		}
	}

	if ($basemodel) {
		$m = new TesTModel();
		$u = $m->getUsers();
		//print_r($u);

		$pt = $m->getParam();
		//print_r($pt);

		$ptbytip = $m->getParamByTip(array('PARAM_TIP_KODU' => 'CIM'));
		print_r($ptbytip);
	}
	//Debugbar::info($c);
	//Debugbar::info($c2);
	//print_r(ApiDsap\test2::hello());
	//print_r($c);
	return View::make('hello');

}); // end of closure for route "/" -> site base location
*/

/* Api dışı kullanım gerekirse devrede olacak
*  Proje yalnızca api olarak kullanılacaksa silinecek
*  - Ertunç 26.11.2014
*/
Route::get('/', function()
{
	return View::make('index');
});

Route::group(array('prefix' => 'api/v1'), function() {

    Route::resource('authenticate', 'ApiAuthController');
    Route::resource('mainmenu', 'MainMenuController');
    Route::resource('sevkmenu', 'SevkMenuController');
    Route::resource('sevk', 'SevkController');
});

/* deneysel routelar
login - silinecek
logout - silinecek
apilogin - silinecek
apilogout - silinecek
*/

// route to show the login form -silinecek
Route::get('login',array('uses' => 'HomeController@showLogin'));

// route to process the form -silinecek
Route::post('login',array('uses' => 'HomeController@doLogin'));

// route to logout the user -silinecek
Route::get('logout', array('uses' => 'HomeController@doLogout'));

// api login çağrısı -silinecek
Route::post('apilogin',array('uses' => 'RestController@doLogin'));

// apilogin için get  çağrısı -silinecek
Route::get('apilogin',array('uses' => 'RestController@doLogin'));

// route to logout the user -silinecek
Route::get('apilogout', array('uses' => 'RestController@doLogout'));