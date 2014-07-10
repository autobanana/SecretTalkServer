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

			$result= Article::where('author_id','=',$username)
				->orderBy('created_at','desc')
				->get();
			
				
			$user=UserProfile::where('username','=',$username)
				->first();

			foreach($result as $entity)
			{
				$entity->level=$user->Level;
			}

			return Response::json(array(
						'Response'=>0,
						'Message'=>'Get Article Finish',
						'ArticleList'=>$result->toJson()));


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

	public function getNewarticle()
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
			$MatchArticles=Match::where('username','=',$username)
				->where('status','=','0')
				->get();

			$NewArticleList=[];	

			foreach($MatchArticles as $MatchArticle)
			{
				//$NewArticleList[]=$MatchArticle->toJson();
				$Article=Article::where('id','=',$MatchArticle->article_id)
					->first();
			
				$u_Profile=UserProfile::where('username','=',$Article->author_id)
						->first();
				
				$Article->level=$u_Profile->Level;				

				
				$NewArticleList[]=$Article->toJson();
				
			}			


			if($MatchArticles->count()>=5)
			{

			}
			else
			{	
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
				$target_user_lists=UserProfile::where('Gender','=',$UserProfile->Gender)
					->orWhere('BloodType','=',$UserProfile->BloodType)
					->orWhere('Sign','=',$UserProfile->Sign)
					->orWhere('Interest','=',$UserProfile->Interest)
					->orWhere('Personality','=',$UserProfile->Personality)
					->orWhere('Mood','=',$UserProfile->Mood)
					->orderBy(DB::raw('RAND()'))
					->get();
				
				if($target_user_lists->count()==0&&count($NewArticleList)==0)
				{
					return Response::json(array(
								'Response'=>'1',
								'Message'=>'Can not get match user'
								));
				}


				if($target_user_lists->count()!=0)
				{
						
					//Get How Many Article Need
					$article_count=5-$MatchArticles->count();
					
					foreach($target_user_lists as $user)
					{	
						//Get Article
						$article=Article::where('author_id','=',$user->Username)->first();

							
						if($article!=null && $user->Username!=$username)
						{	
							//Check Whether the article exist or not 
							$CheckMatch=Match::where('article_id','=',$article->id)
									->where('status','=','0')
									->get();
							
							//Check has matched or not
							$CheckHasMatch=Match::where('article_id','=',$article->id)
									->where('username','=',$username)
									->get();
									
							
							if($CheckMatch->count()==0&&$CheckHasMatch->count()==0)
							{	
								//Add New Match Record							
								$match=new Match;
								$match->article_id=$article->id;
								$match->username=$username;
								$match->status=0;
								$match->save();

								//Get User Level Property
								$eachUserProfile=UserProfile::where('username','=',$user->Username)
									->first();
								$article->level=$eachUserProfile->Level;

								//Add to NewArticle List
								$NewArticleList[]=$article->toJson();
								$article_count++;
								if($article_count==5)
									break;
							}
						}			
					}


				}
				else
				{
					
					if($target_user==null&&count($NewArticleList)==0)
					{
						return Response::json(array(
									'Response'=>'2',
									'Message'=>'Can not get any match article'
									));	
					}
				}
			}

			//Return Article
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Get New Article',
						'Article'=>json_encode($NewArticleList)
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
