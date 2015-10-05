<?php namespace Ao\Wcp\Controllers;

use \Input;
use \Redirect;
use \Session;
use \Slugify;
use \View;
use \Validator;
use Ao\Data\Models\Basicdata;
use Ao\Data\Models\Notification;
use Ao\Data\Models\Categories;

class CategoriesController extends WcpController{

	public function __construct(Categories $model)
	{
		// Add authentication filter
		$this->beforeFilter("auth.wcp");
		// Load parent construct
		Parent::__construct();
		// Set controller model
		$this->model = $model;
		// Load select options
		$this->viewdata["selectoptions"] = \Config::get('selectoptions.categories');
		$this->viewdata["menu"] = 2;
	}

	/*
	* Load a list of resources
	*/
	public function index()
	{
		// Get list of items
		$list = $this->model->orderBy("created_at", "desc")->paginate(20);
		// Load view data
		$this->viewdata["list"] = $list;
		$this->viewdata["submenu"] = 2.2;
		// Load view
		return View::make('wcp::pages.categories.list', $this->viewdata);
	}

	/*
	* Load a specified resource
	*/
	public function show($item)
	{
		// Get list of items
		$list = $this->model->orderBy("created_at", "desc")->paginate(20);
		// Load view data
		$this->viewdata["list"] = $list;
		$this->viewdata["submenu"] = 2.2;
		// Load view
		return View::make('wcp::pages.categories.list', $this->viewdata);
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
					"name" => "required",
					"image" => "required|mimes:jpeg,jpg,png,gif|max:200",
					"type" => "required"
		];
		// Validation Messages
		$messages = [
					"name.required" => "The category name is required.",
					"image.required" => "The category image is required.",
					"image.mimes" => "Image format not support, image must be jpeg,jpg,png,gif.",
					"image.max" => "Image file size of 200kb exceeded.",
					"type.required" => "The category type is required."
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
			return Redirect::to('admin/categories')->withInput();
		}
		// Find item with same name and same type
		$item = $this->model->where("type", $data["type"])->where("name", $data["name"])->first();
		// Validate
		if (count($item) > 0) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"That category already exists."]);
			// Redirect back
			return Redirect::to('admin/categories')->withInput();
		}
		// Prep new data
		$newData = [
			"name" => $data["name"],
			"color" => Input::get("color", "#666666"),
			"slug" => Slugify::slugify($data["name"]),
			"type" => $data["type"]
		];
		// Get request image file
		$file = Input::file("image");
		// Get image meta
		$ext = $file->getClientOriginalExtension();
		$filename = md5($file->getClientOriginalName().time());
		$path = "data/img/";
		// Upload image
		$img = \Image::make($file, 60)
					->resize(360, null, function($constrain){ 
							$constrain->aspectRatio(); 
					})->save($path.$filename.".".$ext);
		$newData["image"] = $path.$filename.".".$ext;
		// Save new data
		$this->model->create($newData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"New category created."]);
		// Redirect back
		return Redirect::to('admin/categories');
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
					"name" => "required",
					"image" => "mimes:jpeg,jpg,png,gif|max:200",
					"type" => "required"
		];
		// Validation Messages
		$messages = [
					"name.required" => "The category name is required.",
					"image.mimes" => "Image format not support, image must be jpeg,jpg,png,gif.",
					"image.max" => "Image file size of 200kb exceeded.",
					"type.required" => "The category type is required."
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
		// Find item with same name and same type
		$item = $this->model->where("type", $data["type"])->where("name", $data["name"])->where("id", "!=", $id)->first();
		// Validate
		if (count($item) > 0) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"That category already exists."]);
			// Redirect back
			return Redirect::back();
		}
		// Find model to update
		$item = $this->model->find($id);
		if (!$item) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Category does not exist."]);
			// Redirect back
			return Redirect::back();
		}
		// Prep new data
		$updateData = [
			"name" => $data["name"],
			"color" =>Input::get("color", "#666666"),
			"slug" => Slugify::slugify($data["name"]),
			"type" => $data["type"]
		];
		// 
		if (Input::hasFile("image")) {
			// Get request image file
			$file = Input::file("image");
			// Get image meta
			$ext = $file->getClientOriginalExtension();
			$filename = md5($file->getClientOriginalName().time());
			$path = "data/img/";
			// Upload image
			$img = \Image::make($file, 60)
						->resize(360, null, function($constrain){ 
								$constrain->aspectRatio(); 
						})->save($path.$filename.".".$ext);
			$updateData["image"] = $path.$filename.".".$ext;
			// Delete current image
			if (\File::exists($item->image)) {
				// 
				\File::delete($item->image);
			}
		}
		// Save new data
		$item->update($updateData);
		// Flash message
		Session::flash("system_message", ["level"=>"success",  "access"=>"wcp", "type"=>"page", "message"=>"Category updated."]);
		// Redirect back
		return Redirect::back();
	}

	/*
	* Delete an existing resource
	*/
	public function destroy($id)
	{
		$this->dodestroy($id);
		// Flash message
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Category deleted."]);
		// Redirect back
		return Redirect::to("admin/categories");
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
		Session::flash("system_message", ["level"=>"warning",  "access"=>"wcp", "type"=>"page", "message"=>"Categories deleted."]);
		// Redirect back
		return Redirect::to("admin/categories");
	}

	/*
	* Delete an existing resource
	*/
	public function dodestroy($id)
	{
		$item = $this->model->with()->find($id);
		if (count($item) < 1) {
			// Flash message
			Session::flash("system_message", ["level"=>"danger",  "access"=>"wcp", "type"=>"page", "message"=>"Category does not exist."]);
			// Redirect back
			return Redirect::back();
		}
		// Delete current image
		if (\File::exists($item->image)) {
			// 
			\File::delete($item->image);
		}
		// Delete the item
		$item->delete();
	}
} 

