<?php namespace Ao\Data\Models;

/**
* Basic data model
*/
class Categories extends \Eloquent
{
	
	protected $table = "tk_categories";

	protected $fillable = ["name", "slug", "type", "image"];

	public function events()
	{
		return $this->hasMany("Ao\Data\Models\Events", "category_id");
	}

	public function posts()
	{
		return $this->hasMany("Ao\Data\Models\Posts", "category_id");
	}

	public function post()
	{
		return $this->hasOne("Ao\Data\Models\Posts", "category_id");
	}

}
	
