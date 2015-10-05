<?php namespace Ao\Data\Models;

/**
* Basic data model
*/
class Groups extends \Eloquent
{
	
	protected $table = "tk_groups";

	public function users()
	{
		return $this->belongsToMany("Ao\Data\Models\User", "tk_users_groups", "group_id", "user_id");
	}

}
	
