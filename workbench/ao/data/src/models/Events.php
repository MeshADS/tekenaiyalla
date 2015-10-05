<?php namespace Ao\Data\Models;

use Ao\Data\Models\Categories;
/**
* Basic data model
*/
class Events extends \Eloquent
{
	
	protected $table = "tk_events";

	protected $fillable = ["title", "slug", "description",  "venue", "image", "category_id", "schedule_starts", "schedule_ends"];

	public function category()
	{
		return $this->belongsto("Ao\Data\Models\Categories", "category_id");
	}

	public static function categories()
	{
		return Categories::orderBy("created_at", "asc")->where("type", "events")->get();
	}

}
	
