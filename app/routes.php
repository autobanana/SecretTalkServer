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
	$users=UserPreference::where('Gender','=','boy')
		->orderBy(DB::raw('RAND()'))
		->first();
	
	return Response::json(array(
				'result'=>'-1',
				'user'=>$users->toJson()
				));
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


