<?php namespace Ao\Data\Models;
use Ao\Data\Models\Programs;
/**
* Basic data model
*/
class User extends \Eloquent
{
	
	protected $table = "tk_users";

	protected $hidden = ["password"];

	protected $fillable = ["avatar", "first_name", "last_name", "name", "email", "phone_id", "bio", "facebook", "twitter", "instagram", "username"];

	public function groups()
	{
		return $this->belongsToMany("Ao\Data\Models\Groups", "tk_users_groups", "user_id", "group_id");
	}

	public function posts()
	{
		return $this->hasMany("Ao\Data\Models\Posts", "author_id");
	}

}
	
