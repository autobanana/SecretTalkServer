<?php

class MatchController extends BaseController {
	
	public function getCheck()
	{	
		$timeInterval=86400;

		$matchs=Match::where('status','=',0)
			->where('created_at','<=',date('Y-m-d H:i:s',time()-$timeInterval))
			->get();

		foreach($matchs as $match)
		{
			$match->status=1;
			$match->save();

		}
	
		return $matchs->toJson();
	}


}
