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



}
