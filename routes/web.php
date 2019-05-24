<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Jobs\SendEmailJob;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/send-email', function () {

    dispatch(new SendEmailJob());

    return 'Mail Send Successfully';
});

Auth::routes();

Route::group(['middleware'=>['auth']], function (){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('/users', 'UserController');


    Route::get('/subs', function () {
        if(Gate::allows('subs-only', Auth::user())){
            return view('subs');
        }else{
            return 'You are not a subscriber, subscribe now';
        }
    });

});


