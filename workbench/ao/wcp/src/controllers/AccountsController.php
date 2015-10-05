<?php namespace Ao\Wcp\Controllers;

use \Input;
use \Redirect;
use \Session;
use \Slugify;
use \View;
use \Validator;
use \Sentry;
use Ao\Wcp\Acme\BSGateway;
use Ao\Data\Models\Basicdata;
use Ao\Data\Models\Notification;
use Ao\Data\Models\User;

class AccountsController extends WcpController{

	public function __construct(User $model)
	{
		// Add authentication filter
		$this->beforeFilter("auth.wcp");
		// Load parent construct methos
		Parent::__construct();
		// Load controller model
		$this->model = $model;
		// Load groups
		$groups = Sentry::findAllGroups();
		$groupsArr = ["Select Group"];
		foreach($groups as $group){ $groupsArr[$group->id] = $group->name; }
		$this->viewdata["groups"] = $groupsArr;
		$this->viewdata["menu"] = 5;
	}

	/*
	* Load a list of resources
	*/
	public function index()
	{
		// Get list of items
		$list = $this->model->with(['groups'])->paginate(20);
		// Load view data
		$this->viewdata["list"] = $list;
		$this->viewdata["submenu"] = 5.1;
		// Load view
		return View::make('wcp::pages.accounts.list', $this->viewdata);
	}

	/*
	* Load a specified resource
	*/
	public function show($id)
	{
		// Get list of items
		$item = $this->model->find($id);
		// Get person group
		$group = $item->groups()->first();
		$item->group = $group;
		// Load view data
		$this->viewdata["item"] = $item;
		$this->viewdata["submenu"] = 5.1;
		// Load view
		return View::make('wcp::pages.accounts.profile', $this->viewdata);
	}

	/*
	* Load form to create a new resource resources
	*/
	public function create()
	{
		// Load view

		$this->viewdata["submenu"] = 5.2;
		return View::make('wcp::pages.accounts.create', $this->viewdata);
	}

	/*
	* Save new resource
	*/
	public function store()
	{
		// Request data
		$data = Input::all();
		// Validation Rules
		$rules = [
			"first_name" => "required",
			"last_name" => "required",
			"email" => "required|email",
			"username" => "required|unique:tk_users,username|alpha_dash",
			"password" => "required|min:8|confirmed",
			"password_confirmation" => "required_with:password"
		];
		// Validation Messages
		$messages = [
			"first_name.required" => "Please enter a first name.",
			"last_name.required" => "Please enter a last name.",
			"email.required" => "Please enter an email.",
			"email.email" => "Please enter a valid email.",
			"username.required" => "Please enter a username.",
			"username.unique" => "That username is already in use.",
			"username.alpha_dash" => "Username must conform to only alphabets, numbers, dashes or underscores.",
			"password.required" => "Please enter a password.",
			"password.min" => "Password must have atleast 8 characters.",
			"password.confirmed" => "Confirmation password does not match password.",
			"password_confirmation.required_with" => "Please confirm password.",
		];
		// Validation
		$validation = Validator::make($data, $rules, $messages);
		// Do validations
		if ($validation->fails()) {
			// Validation errors
			$messages = $validation->errors()->getMessages();
			$message = "";
			// Loop through validation errors
			foreach($messages as $m){
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::to('admin/accounts/create')->withInput();
		}
		// Get group
		$group = Sentry::findGroupById($data["group"]);
		// Get permissions
		$permissions = \Config::get("permissions.".str_replace(" ", "_", $group->name));
		$activate = Input::get("activate", false);
		$activate = ($activate === false) ? false : true;
		// Prep new data
		$newData = [
			"first_name" => $data["first_name"],
			"last_name" => $data["last_name"],
			"email" => $data["email"],
			"username" => $data["username"],
			"bio" => $data["bio"],
			"facebook" => (strlen($data["facebook"]) < 1) ? null : $data["facebook"],
			"instagram" => (strlen($data["instagram"]) < 1) ? null : $data["instagram"],
			"twitter" => (strlen($data["twitter"]) < 1) ? null : $data["twitter"],
			"password" => $data["password"],
			"permissions" => $permissions,
			"activated" => $activate
		];

		try
		{
		    // Create the user
		    $user = Sentry::createUser($newData);

		    // Find the group using the group id
		    $userGroup = Sentry::findGroupById($data["group"]);

		    // Assign the group to the user
		    $user->addGroup($userGroup);

			// Flash message
			Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"New Account created."]);
			// Redirect back
			return Redirect::to('admin/accounts');
		}
		catch (\Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    // Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account already exists."]);
			// Redirect back
			return Redirect::to('admin/accounts/create')->withInput();
		}
		catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Group does not exist."]);
			// Redirect back
			return Redirect::to('admin/accounts/create')->withInput();
		}
	}

	/*
	* Update an existing resource
	*/
	public function update($id)
	{
		// Request data
		$data = Input::all();
		// Validation Rules
		$rules = [
			"first_name" => "required",
			"last_name" => "required",
			"email" => "required|email",
			"username" => "required|alpha_dash|unique:tk_users,username,".$id,
			"group" => "required|exists:tk_groups,id",
		];
		// Validation Messages
		$messages = [
			"first_name.required" => "Please enter a first name.",
			"last_name.required" => "Please enter a last name.",
			"email.required" => "Please enter an email.",
			"email.email" => "Please enter a valid email.",
			"username.required" => "Please enter a username.",
			"username.unique" => "That username is already in use.",
			"username.alpha_dash" => "Username must conform to only alphabets, numbers, dashes or underscores.",
			"group.required" => "Please select a group.",
			"group.exists" => "Selected group was not found.",
		];
		// Validation
		$validation = Validator::make($data, $rules, $messages);
		// Check validation
		if ($validation->fails()) {
			// Validation errors
			$messages = $validation->errors()->getMessages();
			$message = "";
			// Loop through validation errors
			foreach($messages as $m){
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		// find model
		$item = $this->model->with("groups")->find($id);
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account was not found."]);
			// Redirect back
			return Redirect::back();
		}
		// Find group
		$group = Sentry::findGroupById($data["group"]);
		// Get permissions
		$permissions = \Config::get("permissions.".str_replace(" ", "_", $group->name));
		// Prep new data
		try
		{
		    // Find the user using the user id
		    $user = Sentry::findUserById($id);

		    // Update the user details
		    $user->first_name = $data["first_name"];
		    $user->last_name = $data["last_name"];
		    $user->email = $data["email"];
		    $user->username = $data["username"];
		    $user->bio = $data["bio"];
			$user->facebook = (strlen($data["facebook"]) < 1) ? null : $data["facebook"];
			$user->instagram = (strlen($data["instagram"]) < 1) ? null : $data["instagram"];
			$user->twitter = (strlen($data["twitter"]) < 1) ? null : $data["twitter"];
		    $user->permissions = $permissions;

		    // Update the user
		    if ($user->save())
		    {
		        // User information was updated
		        // Remove old group
				$item->groups()->detach();
				// Attach new group
				$item->groups()->attach($data["group"]);
				// Flash message
				Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Account successfully updated."]);
				// Redirect back
				return Redirect::back();
		    }
		    else
		    {
		        // User information was not updated
		        // Flash message
				Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account failed to update, please try again later."]);
				// Redirect back
				return Redirect::back();
		    }
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    // Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"An account bearing that email address already exists."]);
			// Redirect back
			return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account was not found."]);
			// Redirect back
			return Redirect::back();
		}

	}

	/*
	* Update an existing resource
	*/
	public function change_password($id)
	{
		// Request data
		$data = Input::all();
		// Validation Rules
		$rules = [
			"password" => "required|min:8|confirmed",
			"password_confirmation" => "required_with:password"
		];
		// Validation Messages
		$messages = [
			"password.required" => "Please enter a password.",
			"password.min" => "Password must have atleast 8 characters.",
			"password.confirmed" => "Confirmation password does not match password.",
			"password_confirmation.required_with" => "Please confirm password.",
		];
		// Validation
		$validation = Validator::make($data, $rules, $messages);
		// Check validation
		if ($validation->fails()) {
			// Validation errors
			$messages = $validation->errors()->getMessages();
			$message = "";
			// Loop through validation errors
			foreach($messages as $m){
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		try
		{
		    // Find the user by the user's ID
		    $user = Sentry::findUserById($id);

		    // Get the password reset code
		    $resetCode = $user->getResetPasswordCode();

		    // Attempt to reset the user password
	        if ($user->attemptResetPassword($resetCode, $data["password"]))
	        {
	        	// Password reset passed
	            // Flash message
				Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Password was successfully changed."]);
				// Redirect back
				return Redirect::back();
	        }
	        else
	        {
	            // Password reset failed
	            // Flash message
				Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Password reset faile, please try again later."]);
				// Redirect back
				return Redirect::back();
	        }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		   // Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account was not found."]);
			// Redirect back
			return Redirect::back();
		}
	}

	/*
	* Toggle activation for an existing resource
	*/
	public function activate($id)
	{
		try
		{
		    // Find the user by the user's ID
		    $user = Sentry::findUserById($id);
		    // Let's get the activation code
		    $activationCode = $user->getActivationCode();
		     // Attempt to activate the user
		    if ($user->attemptActivation($activationCode))
		    {
		        // User activation passed
		        // Flash message
				Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Account successfully activated."]);
				// Redirect back
				return Redirect::back();
		    }
		    else
		    {
		        // User activation failed
		        // Flash message
				Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account activation failed, please try again later."]);
				// Redirect back
				return Redirect::back();
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		   	// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account was not found."]);
			// Redirect back
			return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
		{
		    // Flash message
			Session::flash("system_message", ["level"=>"info",  "access"=>"wcp", "type"=>"page", "message"=>"Account is already activated."]);
			// Redirect back
			return Redirect::back();
		}
	}

	/*
	* Delete an existing resource
	*/
	public function destroy($id)
	{
		$this->dodestroy($id);
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Account deleted."]);
		// Redirect back
		return Redirect::to("admin/accounts");
	}

	/*
	* Bulk delete an existing resource
	*/
	public function bulkDestroy()
	{
		// Request data
		$data = Input::all();
		// Validation Rules
		$rules = [
					"list" => "required",
		];
		// Validation Messages
		$messages = [
					"list" => "Please select items to delete."
		];
		// Validation
		$validation = Validator::make($data, $rules, $messages);
		// Do validations
		if ($validation->fails()) {
			// Validation errors
			$messages = $validation->errors()->getMessages();
			$message = "";
			// Loop through validation errors
			foreach($messages as $m){
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		// Delete items
		foreach ($data["list"] as $id) {
			$this->dodestroy($id);
		};
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Selected accounts successfully deleted."]);
		// Redirect back
		return Redirect::to("admin/accounts");
	}

	/*
	* Delete an existing resource
	*/
	public function dodestroy($id)
	{
		$user = Sentry::getUser();
		$item = $this->model->with("groups")->find($id);
		if ($item->email == $user->email) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"You can't delete your account."]);
			// Redirect back
			return Redirect::back();
		}
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Account not exist."]);
			// Redirect back
			return Redirect::back();
		}
		// Detach from group
		$item->groups()->detach();		
		// Delete the item
		$item->delete();
	}
} 

