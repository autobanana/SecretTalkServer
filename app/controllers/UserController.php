<?php


class UserController extends BaseController {

	public function getIndex()
	{
		return "123";
	}

	public function getCreate()
	{
		if(Request::isJson())
		{	
			$request=Input::get('request');
			
			$request=json_decode($request);	
			
			$username=$request['username'];
			$password=$request['password'];
			$nickname=$request['nickname'];
			$realname=$request['realname'];	
			$birthday=$request['birthday'];

			if($username==null||$password==null
					||$nickname==null||$realname==null
					||$birthday==null
			  )	
				return Response::json(array(
							'Result'=>'-1',
							'Message'=>'Lost Input'
							));

			$count=User::where('Username','=',$username)->count();		
			if($count>0)
				return Response::json(array(
							'Result'=>'-1',
							'Message'=>'User Exist'
							));

			$user =new User;
			$user->Username=$username;
			$user->Userpasswd=$password;
			$user->Nickname=$nickname;
			$user->Realname=$realname;
			$user->Birthday=$birthday;
			$user->save();	

			return Response::json(array(
						'Result'=>'0',
						'Messague'=>'Register Success'
						));			
		}
		else
		{
			return Response::json(array(
						'Resutl'=>'-1',
						'Message'=>'Input Format Error'
						));

		}
	}

	public function getLogin()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			$request1=json_decode($request,true);
			
			$username=$request1['username'];
			$password=$request1['password'];
			
			$count=User::where('Username','=',$username)
				   ->where('Userpasswd','=',$password)
				   ->count();
			if($count==1)
			{
				return Response::json(array(
							'Response'=>'0',
							'Message'=>'Login Success'
							));
			}
			else
			{
				return Response::json(array(
							'Response'=>'-1',
							'Message'=>'Login Fail'
							));
			}
			
		}
		else
		{
			return Response::json(array(
						'Respone'=>'-1',
						'Message'=>'Input Format Error'
						));
		}

	}
	

	public function getLogout()
	{

		
	}
	

}
