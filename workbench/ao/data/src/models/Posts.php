<?php namespace Ao\Data\Models;
use Ao\Data\Models\Posts;
/**
* Basic data model
*/
class Posts extends \Eloquent
{
	
	protected $table = "tk_posts";

	protected $fillable = ["title", "slug", "image", "thumbnail", "category_id", "caption", "publish_state", "body", "author_id"];

	public function category()
	{
		return $this->belongsTo("Ao\Data\Models\Categories", "category_id");
	}
	public function author()
	{
		return $this->belongsTo("Ao\Data\Models\User", "author_id");
	}

	// public function comments()
	// {
	// 	return $this->hasMany("Ao\Data\Models\Comments", "post_id");
	// }

	// public function comment()
	// {
	// 	return $this->hasOne("Ao\Data\Models\Comments", "post_id");
	// }

	public function categories()
	{
		return Categories::orderBy("created_at", "asc")->where("type", "posts")->get();
	}

	public static function published()
	{
		return Posts::where("publish_state", 1);
	}

}
	
