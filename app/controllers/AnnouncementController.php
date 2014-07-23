<?php

class AnnouncementController extends BaseController {



	public function anyRetrieve()
	{
		$announcement = Announcement::all();
		return Response::json(array(
					'Response'=>0,
					'Message'=>'Get Announcement Finish',
					'AnnouncementList'=>$announcement->toJson()));
	}
	
	public function postCreate()
	{
		$announcement=new Announcement;
		$announcement->content=Input::get('content');	
		$announcement->status=0;
		$announcement->save();
		return Redirect::to('announcement/management');

	}

	public function getManagement()
	{	
		if(Auth::check())
		{
			$announcements=Announcement::all();	
			return View::make('AnnouncementPage')->with('announcements',$announcements); 
	
		}
		else
		{
			return Redirect::to('manage/index');
		}
	}
}
