<?php namespace Ao\Wcp\Controllers;

use \Input;
use \Redirect;
use \Response;
use \Request;
use \Session;
use \Slugify;
use \View;
use \Image;
use \File;
use \Validator;
use Ao\Data\Models\Basicdata;
use Ao\Data\Models\Notification;
use Ao\Data\Models\Posts;

class PostsController extends WcpController{

	public function __construct(Posts $model)
	{
		// Add authentication filter
		$this->beforeFilter("auth.wcp");
		// Load parent construct
		Parent::__construct();
		// Set controller model
		$this->model = $model;
		// Load posts categories
		$categories = $this->model->categories();
		$catArray = [ "" => "Select Category"];
		foreach($categories as $v){
			$catArray[$v->id] = $v->name;
		};
		$this->viewdata["categories"] = $catArray;
		$this->viewdata["menu"] = 4;
	}
	
	/*
	* Return a list of resources
	*/
	public function index()
	{
		$search = Input::get("search", null);
		// Fetch list of model
		$list = $this->model->orderBy("created_at", "desc")->with(["category", "author"]);
		// Check for search param
		if (!is_null($search)) {
			$list = $list->where("title", "LIKE", "%".$search."%");
		}
		$list = $list->paginate(20);
		// Load view data
		$this->viewdata["list"] = $list;
		$this->viewdata["search"] = $search;
		$this->viewdata["submenu"] = 4.1;
		// Load view
		return View::make('wcp::pages.posts.list', $this->viewdata);
	}

	/*
	* Return a specified resource
	*/
	public function show($id)
	{
		// Fetch list of model
		$item = $this->model->with(["category", "author"])->find($id);
		// Validate model
		if (count($item) < 1) { return \App::abort(404); }
		// Load view data
		$this->viewdata["item"] = $item;
		$this->viewdata["submenu"] = 4.1;
		// Load view
		return View::make('wcp::pages.posts.show', $this->viewdata);
	}

	/*
	* Return a list of resources
	*/
	public function comments($id)
	{
		// Fetch list of model
		$item = $this->model->with(["category", "author"])->find($id);
		$list = $item->comments()->orderBy("created_at", "desc")->paginate(20);
		// Validate model
		if (count($item) < 1) { return \App::abort(404); }
		// Load view data
		$this->viewdata["item"] = $item;
		$this->viewdata["list"] = $list;
		$this->viewdata["submenu"] = 4.1;
		// Load view
		return View::make('wcp::pages.posts.comments.list', $this->viewdata);
	}

	/*
	* Shows a form for creating a resource
	*/
	public function create()
	{
		$group = \Sentry::findGroupByName('Administrators');
		$users = \Sentry::findAllUsersInGroup($group);

		// Load view
		$this->viewdata["submenu"] = 4.2;
		$this->viewdata["authors"] = $users;
		return View::make('wcp::pages.posts.create', $this->viewdata);
	}

	/*
	* Shows a form for editting a resource
	*/
	public function edit($id)
	{
		// Fetch list of model
		$item = $this->model->with(["category"])->find($id);
		// Validate model
		if (count($item) < 1) { return \App::abort(404); }
		// Load authors
		$group = \Sentry::findGroupByName('Administrators');
		$users = \Sentry::findAllUsersInGroup($group);
		// Load view data
		$this->viewdata["item"] = $item;
		$this->viewdata["authors"] = $users;
		$this->viewdata["submenu"] = 4.1;
		// Load view
		return View::make('wcp::pages.posts.edit', $this->viewdata);
	}

	/*
	* Store a newly created resource
	*/
	public function store()
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"title" => "required|unique:tk_posts",
			"body" => "required",
			"category_id" => "required|exists:tk_categories,id",
			"author_id" => "required|exists:tk_users,id",
			"caption" => "required",
			"image" => "required|max:1200|mimes:jpeg,jpg,png",
		];
		// Validation messages
		$messages = [
			"title.required" => "The post's title is required.",
			"title.unique" => "A post with that title already esists.",
			"body.required" => "Your post's content is empty.",
			"category_id.required" => "Please select a category for this post.",
			"category_id.eixsts" => "The selected category was not found.",
			"author_id.required" => "Please select an author for this post.",
			"author_id.eixsts" => "The selected author was not found.",
			"caption.required" => "Please enter a caption for your post",
			"image.required" => "Please select a header image for your new post.",
			"image.max" => "File size limit of 1200kb exceeded.",
			"image.max" => "Unsupported file types, supported file types are jpeg and png.",
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back()->withInput();
		}
		// Validate for an image
		if (!Input::hasFile('image')) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Please select a header image for your new post."]);
			// Redirect back
			return Redirect::back()->withInput();
		}
		// Upload image file
		$file = Input::file('image');
		$thumbnail = $file;
		$filename = $file->getClientOriginalName();
		$filename = md5($filename.time().rand(0, 100000));
		$thumb_filename = md5($filename.'thumbnail');
		$ext = $file->getClientOriginalExtension();
		$path = "data/img/";
		$thumb_path = "data/img/thumbnail/";
		// Move main image to destination folder
		\Image::make($file, 75)->resize(1280, null, function($constrain){ $constrain->aspectRatio(); })->save($path.$filename.".".$ext);
		// Move thumbnail to thumbnail destination folder
		\Image::make($thumbnail, 60)->resize(480, null, function($constrain){ $constrain->aspectRatio(); })->save($thumb_path.$thumb_filename.".".$ext);
		// Prep new data
		$publish = Input::get("publish", 0);
		$newData = [
			"title" => $data["title"],
			"slug" => Slugify::slugify($data["title"]),
			"body" => $data["body"],
			"category_id" => $data["category_id"],
			"author_id" => $data["author_id"],
			"caption" => $data["caption"],
			"thumbnail" => $thumb_path.$thumb_filename.".".$ext,
			"image" => $path.$filename.".".$ext,
			"publish_state" => $publish,
		];
		// Store new data
		$model = $this->model->create($newData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"New post created."]);
		// Redirect back
		return Redirect::to("admin/posts/".$model->id);
	}

	/*
	* Update an existing resource
	*/
	public function update($id)
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"title" => "required|unique:tk_posts,title,".$id,
			"body" => "required",
			"category_id" => "required|exists:tk_categories,id",
			"author_id" => "required|exists:tk_users,id",
			"caption" => "required",
			"image" => "max:1200|mimes:jpeg,jpg,png",
		];
		// Validation messages
		$messages = [
			"title.required" => "The post's title is required.",
			"title.unique" => "A post with that title already esists.",
			"body.required" => "Your post's content is empty.",
			"category_id.required" => "Please select a category for this post.",
			"category_id.eixsts" => "The selected category was not found.",
			"author_id.required" => "Please select an author for this post.",
			"author_id.eixsts" => "The selected author was not found.",
			"caption.required" => "Please enter a caption for your post",
			"image.max" => "File size limit of 1200kb exceeded.",
			"image.max" => "Unsupported file types, supported file types are jpeg and png.",
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		// Find model
		$item = $this->model->find($id);
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Post not found."]);
			// Redirect back
			return Redirect::back();
		}
		// Prep new data
		$publish = Input::get("publish", 0);
		$updateData = [
			"title" => $data["title"],
			"slug" => Slugify::slugify($data["title"]),
			"body" => $data["body"],
			"category_id" => $data["category_id"],
			"author_id" => $data["author_id"],
			"caption" => $data["caption"],
			"publish_state" => $publish,
		];
		// Upload if new file is selected
		if (Input::hasFile('image')) {
			// Upload image file
			$file = Input::file('image');
			$thumbnail = $file;
			$filename = $file->getClientOriginalName();
			$filename = md5($filename.time().rand(0, 100000));
			$thumb_filename = md5($filename.'thumbnail');
			$ext = $file->getClientOriginalExtension();
			$path = "data/img/";
			$thumb_path = "data/img/thumbnail/";
			// Move main image to destination folder
			\Image::make($file, 75)->resize(1280, null, function($constrain){ $constrain->aspectRatio(); })->save($path.$filename.".".$ext);
			// Move thumbnail to thumbnail destination folder
			\Image::make($thumbnail, 60)->resize(480, null, function($constrain){ $constrain->aspectRatio(); })->save($thumb_path.$thumb_filename.".".$ext);
			// Delete post's current image
			if (File::exists($item->thumbnail)) { File::delete($item->thumbnail); }			
			if (File::exists($item->image)) { File::delete($item->image); }	
			$updateData["thumbnail"] = $thumb_path.$thumb_filename.".".$ext;	
			$updateData["image"] = $path.$filename.".".$ext;
		}
		// Update item
		$item->update($updateData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Post updated."]);
		// Redirect back
		return Redirect::to("admin/posts/".$item->id);
	}

	/*
	* Store a newly created resource
	*/
	public function storecomment($id)
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"name" => "required",
			"message" => "required"
		];
		// Validation messages
		$messages = [
			"name.required" => "The name field is required.",
			"message.required" => "The comment field is required."
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back()->withInput();
		}
		// Get item
		$item = $this->model->find($id);
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Post does not exist."]);
			// Redirect back
			return Redirect::back()->withInput();
		}
		// Prep new data
		$user = \Sentry::getUser();
		$newData = [
				"name" => $data['name'],
				"email" => $user->email,
				"message" => $data["message"],
				"publish" => 1,
				"type" => 1
		];
		// Store new data
		$model = $item->comments()->create($newData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"New comment posted."]);
		// Redirect back
		return Redirect::back();
	}

	/*
	* Update a specified resource's comment
	*/
	public function updatecomment($id, $id2)
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"name" => "required",
			"message" => "required"
		];
		// Validation messages
		$messages = [
			"name.required" => "The name field is required.",
			"message.required" => "The comment field is required."
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back()->withInput();
		}
		// Find model
		$item = $this->model->with(["comment"=>function($query) use($id2){
			$query->find($id2);
		}])->find($id);
		if (count($item) < 1 || count($item->comment) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Comment was not found."]);
			// Redirect back
			return Redirect::back();
		}
		// Prep new data
		$publish = Input::get("publish", 0);
		$updateData = [
			"name" => $data['name'],
			"message" => $data["message"],
			"publish" => $publish,
			"type" => $item->type
		];
		// Update item
		$item->comment->update($updateData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Comment updated."]);
		// Redirect back
		return Redirect::to("admin/posts/".$item->id."/comments");
	}	

	/*
	* Delete an existing resource
	*/
	public function destroy($id)
	{
		$this->dodestroy($id);
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Post deleted."]);
		// Redirect back
		return Redirect::to("admin/posts");
	}

	/*
	* Delete a list of resources
	*/
	public function bulkdestroy()
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"list" => "required"
		];
		// Validation messages
		$messages = [
			"list.required" => "Please select the posts to delete."
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		foreach ($data["list"] as $id) {
			$this->dodestroy($id);
		}
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Selected posts were successfully deleted."]);
		// Redirect back
		return Redirect::back();

	}

	/*
	* Delete an existing resource
	*/
	public function destroycomment($id, $id2)
	{
		$this->dodestroycomments($id, $id2);
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Comment deleted."]);
		// Redirect back
		return Redirect::back();
	}

	/*
	* Delete a list of resources
	*/
	public function destroycomments($id)
	{
		// Get request data
		$data = Input::all();
		// Validation rules
		$rules = [
			"list" => "required"
		];
		// Validation messages
		$messages = [
			"list.required" => "Please select the comments to delete."
		];
		// Perform validation
		$validation = Validator::make($data, $rules, $messages);
		// Verify validation status
		if ($validation->fails()) {
			$messages = $validation->errors()->getMessages();
			$message = "";
			foreach ($messages as $m) {
				$message .= $m[0]."<br>";
			}
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>$message]);
			// Redirect back
			return Redirect::back();
		}
		foreach ($data["list"] as $id2) {
			$this->dodestroycomments($id, $id2);
		}
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Selected comments were successfully deleted."]);
		// Redirect back
		return Redirect::back();
	}

	/*
	* Perform delete action for a specified resource
	*/
	public function dodestroy($id)
	{
		// Find the item
		$item = $this->model->with("comments")->find($id);
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Post not found."]);
			// Redirect back
			return Redirect::back();
		}
		// Delete item image files
		if (File::exists($item->thumbnail)) { File::delete($item->thumbnail); }
		if (File::exists($item->image)) { File::delete($item->image); }
		// Delete comments
		$item->comments()->delete();
		// Delete item
		$item->delete();
	}

	/*
	* Perform delete action for a specified resource
	*/
	public function dodestroycomments($id, $id2)
	{
		// Find the item
		$item = $this->model->with(["comment" => function($query) use($id2){
			$query->find($id2);
		}])->find($id);
		if (count($item) < 1 || count($item->comment) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Comment not found."]);
			// Redirect back
			return Redirect::back();
		}
		// Delete comments
		$item->comment->delete();
	}
} 

