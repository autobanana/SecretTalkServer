<?php

class Article extends Eloquent
{
	protected $table = "ArticleTable";
	public $timestamps = true ;
	

	public function replys()
	{
		return $this->hasManay('Reply','article_id');
	}

}
