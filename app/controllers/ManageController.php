<?php

class ManageController extends BaseController {

	public function anyIndex()
	{
		return View::make('ManageLoginPage');
	}

	public function postLogin()
	{
		$username=Input::get('username');
		$password=Input::get('password');
		
		if(Auth::attempt(array('username'=>$username,'password'=>$password),true))
		{
			return Redirect::to('manage/controlpanel');			

		}	
		else
		{
			echo $username;
			echo $password;
			return 'fail';
		}

	}
	
	public function anyControlpanel()
	{
		if (Auth::check())
		{
			return View::make('ControlPanel');	
		}
		else
		{
			return Redirect::to('manage/index');
		}

	}
	
	public function anyUsermanagement()
	{	
		if(Auth::check())
		{	
			$users=User::all();
			return View::make('UserManagement')->with('users',$users);
		}
		else
		{
			return Redirect::to('manage/index');
		}
	}

	public function getSpeak($username)
	{
		if(Auth::check())
		{
			$Articles=Article::where('author_id','=',$username)->get();
			return View::make('Speak')->with('articles',$Articles);	
		}
		else
		{
			return Redirect::to('manage/index');
		}
	}
	
	public function getArticleReply($article_id)
	{
		if(Auth::check())
		{
			$replys=Reply::where('article_id','=',$article_id)
					->get();
			return View::make('ArticleReply')->with('replys',$replys);
		}
		else
		{
			return Redirect::to('manage/index');

		}	
	}

	public function getListen($username)
	{	
		if(Auth::check())
		{
			$matchArticles = Match::where('username','=',$username)
					->get();	
			foreach($matchArticles as $matchArticle)
			{
				$article=Article::where('id','=',$matchArticle->article_id)
					->first();
				$matchArticle->article_author_id=$article->author_id;
				$matchArticle->content=$article->content;				

			}
			return View::make('Listen')->with('matchArticles',$matchArticles);
		}
		else
		{
			return Redirect::to('manage/index');
		}
	}

	public function anyRegister()
	{	
		/*
		$ManageUser=new ManageUser;
		$ManageUser->username='autobanana';
		$ManageUser->password=Hash::make('secrettalk');
		$ManageUser->save();
		*/
	}



}
