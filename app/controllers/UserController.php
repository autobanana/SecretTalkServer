<?php

class UserController extends BaseController {

	public function getIndex()
	{
		return "123";
	}

	public function anyCreate()
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

	public function anyLogin()
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
				$token=new Token;
				$token->username=$username;
				$token_pass=substr(md5(rand()),0,31);
				$token->token=$token_pass;
				$token->save();
				
				return Response::json(array(
							'Response'=>'0',
							'Message'=>'Login Success',
							'Username'=>$username,
							'Token'=>$token_pass
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
			$request=json_decode($request,true);
			
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
				$R_UserProfile['Gender']=$UserProfile->Gender;
				$R_UserProfile['BloodType']=$UserProfile->BloodType;
				$R_UserProfile['Sign']=$UserProfile->Sign;
				$R_UserProfile['Interest']=$UserProfile->Interest;
				$R_UserProfile['Personality']=$UserProfile->Personality;
				$R_UserProfile['Level']=$UserProfile->Level;
				$R_UserProfile['Score']=$UserProfile->Score;
				$R_UserProfile['Mood']=$UserProfile->Mood;		
			
				$R_UserProfile['Birthday']=$UserInformation->Birthday;
				$R_UserProfile['Nickname']=$UserInformation->Nickname;
				$R_UserProfile['created_at']=$UserInformation->created_at;
				
				$CreateTime=strtotime($UserInformation->created_at);
				$NowTime=time();
				$LoginDays=$NowTime-$CreateTime;
				
				$LoginDays=floor($LoginDays/(60*60*24));

				$R_UserProfile['LoginDays']=$LoginDays;

				return Response::json(array(
						'Response'=>'0',
						'Message'=>'Get User Profile Success',
						'UserProfile'=>json_encode($R_UserProfile)
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
			
			$UserProfiles=UserProfile::where('Username','=',$username)
					->get();

			if($UserProfiles->count()!=0)
			{
				$UserProfile=$UserProfiles->first();
			}
			
			else
			{
				$UserProfile=new UserProfile;
				$UserProfile->Username=$username;
			}
					
			
			$UserProfile->Mood=$mood;
			$UserProfile->Interest=$interest;
			$UserProfile->Personality=$personality;
			
			$UserProfile->save();

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
