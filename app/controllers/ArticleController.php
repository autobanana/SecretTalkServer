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
				$replyReads=ReplyRead::where('article_id','=',$entity->id)
						->where('username','=',$username)
						->get();
				if($replyReads->count()==0)
				{
					$entity->isNew='true';
				}
				else
				{
					$replyRead=$replyReads->first();
					$replys=Reply::where('created_at','>',$replyRead->readtime)
						->where('article_id','=',$entity->id)
						->get();
					if($replys->count()>0)
						$entity->isNew='true';
					else
						$entity->isNew='false';	
				}
				
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
			//Get Request
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
			
			//Initial Return List
			$NewArticleList=[];
			

			foreach($MatchArticles as $MatchArticle)
			{
				//Get the article
				$Article=Article::where('id','=',$MatchArticle->article_id)
					->first();

				//Get User Profile
				$u_Profile=UserProfile::where('username','=',$Article->author_id)
						->first();

				//Get User Information
				$u_Information=User::where('Username','=',$Article->author_id)
						->first();
				
				//Add level and nickname information	
				$Article->level=$u_Profile->Level;				
				$Article->nickname=$u_Information->Nickname;
				
				//Get the ReplyRead time to check whether there is new reply or not
				$ReplyReads = ReplyRead::where('article_id','=',$MatchArticle->article_id)
						->where('username','=',$username)
						->get();

				if($ReplyReads->count()!=0)
				{
					$ReplyRead=$ReplyReads->first();					
					$replys=Reply::where('created_at','>',$ReplyRead->readtime)
						->where('article_id','=',$MatchArticle->id)
						->get();
					if($replys->count()>0)
						$Article->isNew='true';
					else
						$Article->isNew='false';	
	
				}
				else
				{
					$Article->isNew='true';
				}
	
				//Add article to newarticlelist
				$NewArticleList[]=$Article->toJson();
				
			}			

			//If the Article Is More Than 5 DO NOTHING
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
				
				//If there is no match user then return
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

					$count=0;					

					foreach($target_user_lists as $user)
					{	
						//Get Article
						$article=Article::where('author_id','=',$user->Username)->first();
							
						if($article!=null && $user->Username!=$username)
						{	
							//Check Whether the article exist or not 
							$CheckMatch=Match::where('article_id','=',$article->id)
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
								
								//Get Username Property
								$eachUserInformation=User::where('Username','=',$user->Username)
												->first();				
								$article->nickname=$eachUserInformation->Nickname;			
								
								//Check whether it is new
								$ReplyReads = ReplyRead::where('article_id','=',$article->id)
											->where('username','=',$username)
											->get();

								if($ReplyReads->count()!=0)
								{		
									$ReplyRead=$ReplyReads->first();					
									$replys=Reply::where('created_at','>',$ReplyRead->readtime)
										->where('article_id','=',$article->id)
										->get();
									if($replys->count()>0)
										$article->isNew='true';
									else
										$article->isNew='false';	
	
								}
								else
								{
									$article->isNew='true';
								}
							
								//Add to NewArticle List
								$NewArticleList[]=$article->toJson();
								$count++;
								if($article_count==$count)
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
