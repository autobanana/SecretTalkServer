<?php

class UserController extends BaseController {

	public function getIndex()
	{
		return "123";
	}

	public function getCreate()
	{
		if(Input::has('request'))
		{	
			$request=Input::get('request');
			
			$request=json_decode($request,true);	
			
			$username=$request['username'];
			$password=$request['password'];
			$nickname=$request['nickname'];
			$realname=$request['realname'];	
			$birthday=$request['birthday'];
	
			$sign=$request['sign'];			
			$gender=$request['gender'];
			$bloodType=$request['bloodType'];
			

			if($username==null||$password==null
					||$nickname==null||$realname==null
					||$birthday==null
			  )	
				return Response::json(array(
							'Response'=>'-1',
							'Message'=>'Lost Input'
							));

			$count=User::where('Username','=',$username)->count();		
			if($count>0)
				return Response::json(array(
							'Response'=>'-1',
							'Message'=>'User Exist'
							));

			$user =new User;
			$user->Username=$username;
			$user->Userpasswd=$password;
			$user->Nickname=$nickname;
			$user->Realname=$realname;
			$user->Birthday=$birthday;
			$user->save();	
			
			$userProfile=new UserProfile;
			$userProfile->Username=$username;
			$userProfile->Gender=$gender;
			$userProfile->Sign=$sign;
			$userProfile->BloodType=$bloodType;		
			$userProfile->save();
	
			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Register Success'
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
							'Message'=>'Login Success',
							'Username'=>$username
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
						'Message'=>'Input Format Error',						
						));
		}

	}
	

	public function getLogout()
	{

		
	}

	public function getUserprofile()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');	
			$request=json_encode($request,true);
			
			$username=$request['username'];
	
			$UserProfile=UserProfile::where('Username','=',$username)
						->first();
			$UserInformation=User::where('Username','=',$username)
						->first();
			if($UserProfile==null)
			{
				
			}

			else
			{	

				$UserProfile->Birthday=$UserInformation->Birthday;
							
				return Response::json(array(
						'Respone'=>'0',
						'Message'=>'Get User Profile Success',
						'UserProfile'=>$UserProfile->toJson()		
						));

			}
			
		}
		else
		{
			return Response::json(array(
						'Respone'=>'-1',
						'Message'=>'Input Format Error'));
		}

	}	
	public function getSetprofile()
	{
		if(Input::has('request'))
		{
			$request=Input::get('request');
			$request=json_decode($request,true);
			
			$username=$request['username'];
			$mood=$request['mood'];
			$interest=$request['interest'];
			$personality=$request['personality'];
			
			$UserProfile=UserProfile::where('Username','=',$username)
					->get();

			if($UserProfile->count()!=0)
			{
				$UserProfile=$UserProfile->first();
			}
			
			else
			{
				$UserProfile=new UserProfile;
				$UserProfile->Username=$username;
			}
					
			
			$UserProfile->Mood=$mood;
			$UserProfile->Interest=$interest;
			$UserProfile->Personality=$personality;
			
			$UserPreference->save();

			return Response::json(array(
						'Response'=>'0',
						'Message'=>'Save Preference Success'
						));
		}
		else
		{
			
			return Response::json(array(
						'Respone'=>'-1',
						'Message'=>'Input Format Error'));
		}

	}
	

}
