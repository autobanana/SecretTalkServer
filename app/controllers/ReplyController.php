<?php

class ReplyController extends BaseController {
	

	public function getArticle()
	{
		


	}
	
	public function getContent()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			
			$request=json_decode($request,true);
			
			$article_id=$request['article_id'];
			$username=$request['username'];
			if(array_key_exists('timeStamps',$request))
				$timeStamps=$request['timeStamps'];
			else
				$timeStamps=null;
	
			if($article_id==null||$username==null)
			{
				return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Lost Input'
						));
			}
			if($timeStamps==null)
			{	
				$reply=Reply::where('article_id','=',$article_id)
						->orderBy('created_at')
						->get();
			}
			else
			{
				$reply=Reply::where('article_id','=',$article_id)
						->where('created_at','>',new DateTime($timeStamps))
						->orderBy('created_at')
						->get();
			}	
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Get Reply Success',
						'ReplyList'=>$reply->toJson()
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
		
	public function getCreate()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			
			$request=json_decode($request,true);
			
			$username=$request['username'];
			$article_id=$request['article_id'];
			$content=$request['content'];
			/*	
			if($username==null || $content==null || $article_id==null)
			{
				return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Lost Input'
							));
			}
			//
			$reply=Reply::where('article_id','=',$article_id)
					->where('author_id','=',$username)
					->where('status','=',0)
					->get();
								


			if($reply->count()!=0)
			{
				$reply=$reply->first();
				$reply->content=$content;
				$reply->save();

			}
			else
			{
				$reply=new Reply;
				$reply->article_id=$article_id;
				$reply->author_id=$username;
				$reply->content=$content;
				$reply->save();
			}
			*/

			$reply=new Reply;
			$reply->article_id=$article_id;
			$reply->author_id=$username;
			$reply->content=$content;
			$reply->save();
			
			
	
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Save Reply Success',
						'Reply'=>$reply->toJson()
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
