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

Route::get('/', function()
{
	$UserProfile=UserProfile::where('Username','=','secrettalk')
				->first();
	$UserInformation=User::where('Username','=','secrettalk')
				->first();

	$UserProfile->Birthday=$UserInformation->Birthday;
	return $UserProfile->toJson();

});

/*
Route::get('users',function()
{
	return 'users';
});
*/

Route::controller('users' , 'UserController');

Route::controller('article' , 'ArticleController');

Route::controller('reply', 'ReplyController');


