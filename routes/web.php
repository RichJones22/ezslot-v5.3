<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Carbon\Carbon;

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::get('/cover', function() {
    return view('cover');
});

Route::get('/splash', function() {
    return view('splash');
});


Route::get('/metrics', function() {
   for($i=0;$i<100;$i++)
   {
       DB::table('performance_indicators')->insert([
          'monthly_recurring_revenue' => mt_rand(1000, 2000),
          'yearly_recurring_revenue' => mt_rand(50000, 60000),
          'daily_volume' => mt_rand(100, 300),
          'new_users' => mt_rand(50, 100),
          'created_at' => Carbon::now()->subDays($i),
          'updated_at' => Carbon::now()->subDays($i),
       ]);
   }
});