<?php

class UserTableSeeder extends Seeder
{
	
	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'name' => 'Ertunç Efeoğlu',
			'username' => 'ertuncefeoglu',
			'email' => 'ertuncefeoglu@gmail.com',
			'password' => Hash::make('kedi25')
		));
		User::create(array(
			'name' => 'Adil Soydal',
			'username' => 'adilsoydal',
			'email' => 'adilsoydal@sabah.com.tr',
			'password' => Hash::make('kedi25')
		));
	}
}