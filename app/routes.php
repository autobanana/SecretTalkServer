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
	//return View::make('hello');
	$users=UserPreference::where('Gender','=','boy1')
		->orderBy(DB::raw('RAND()'))
		->get();
	$target_user=null;
	foreach($users as $user)
	{
		$target_user=$user->Username;
	}
	return $target_user;
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


