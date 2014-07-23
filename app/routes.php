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
	
	$user=User::where('username','=','dodo')
		->get()
		->first();
	
	return $user->toJson(); 

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

Route::controller('match','MatchController');

Route::controller('announcement','AnnouncementController');

Route::controller('manage','ManageController');
