<?php

class ReplyController extends BaseController {
	

	public function getArticle()
	{
		


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
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Save Reply Success'
						));
			
			
		
		}
		else
		{
			return Response::json(array(
						'Response'=>'-1',
						'Message'=>'Input Formate Error'
						));
		}


	}	
	


}
