<?php

class ArticleController extends BaseController {
	
	public function getIndex()
	{

	}

		
	public function getList()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			
			$request=json_decode($request,true);
			$username=$request['username'];
			
			$result= Article::where('author_id','=',$username)->get();
			return $result->toJson();
			

		}
		else
		{
			return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Input Format Error'
						));
		}

	}

	public function getCreate()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			$request=json_decode($request,true);
			
			$username=$request['username'];
			$content=$request['content'];
			
			if($username==null||$content==null){
				//return $username." ".$content;
				return Response::json(array(
					'Response'=>'-1',
					'Message'=>'Lost Input'
				));
			}
			
			$article=new Article;
			$article->author_id=$username;
			$article->content=$content;
			$article->save();


			return Response::json(array(
					'Response'=>'0',
					'Message'=>'Save Article Success'
				));

			
		}
		else
		{
			return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Input Format Error'
						));
		}

	}
	
	public function getNewArticle()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			$request=json_decode($request,true);
			
			$username=$request['username'];
			
			if($username==null)
			{
				return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Lost Input'
							));
			}

			//Find Whether there are unreply article or not 
			$unreplyArticles=Reply::where('author_id','=',$username)
					->where('status','=',0)
					->get();
			if($unreplyArticles->count()!=0)
			{	
				
				foreach($unreplyArticles as $unreplyArticle)
				{
					$article['article_id']=$unreplyArticle->article_id;
					$article['content']=$unreplyArticle->content;
					break;
				}

				return Response::json(array(
							'Response'=>'0',
							'Message'=>'Unreply Article Found',
							'Artilce'=>$article
							));
			}
			
			//Get User Profile
			$UserProfiles=UserProfile::where('Username','=',$username)
					->get();	
			if($UserProfiles->count()==0)
			{
				return Response::json(array(
							'Response'=>'-1',
							'Message'=>'Can not get User Profile'
							));
			}
			$UserProfile=$UserProfiles[0];
				
			
			//Select A Random User whose Preference Fit this Profile
			$target_user_lists=UserPreference::where('Gender','=',$UserProfile->Gender)
						->orWhere('BloodType','=',$UserProfile->BloodType)
						->orWhere('Sign','=',$UserProfile->Sign)
						->orderBy(DB::raw('RAND()'))
						->get();
			if($target_user_lists->count()==0)
			{
				return Response::json(array(
							'Response'=>'1',
							'Message'=>'Can not get match user'
							));
			}
			
			
			//Use the list to find article
			$target_user=null;
			foreach($targer_user_lists as $user)
			{
				//Get Article
				$article=Article::where('author_id','=',$user->Username)->first();
				if($article!=null)
				{
					$target_user=$user->Username;
					break;
				}			
			}
			
			if($target_user==null)
			{
				return Response::json(array(
							'Response'=>'2',
							'Message'=>'Can not get any match article'
							));
				
			}
			
			//Add Reply 
			$reply=new Reply;
			$reply->article_id=$article->id;
			$reply->author_id=$username;
			$reply->status=0;		
			$reply->save();
			
			//Return Article
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Get New Article',
						'Article'=>$article
						));
						
			
		}
		else
		{
			return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Input Format Error'
					));
		}

	}

 
}
