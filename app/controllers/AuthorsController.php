<?php
use Ao\Data\Models\User;
class AuthorsController extends SiteController {

	/*
	|--------------------------------------------------------------------------
	| Default Pages Controller
	|--------------------------------------------------------------------------
	|
	| Serve's views for routes without explicit functions
	|
	*/

	/**
	 * Controller construct method
	*/
	public function __construct(User $model)
	{
		Parent::__construct();

		$this->model = $model;
	}

	/**
	 * Serve's a list of resources
	 * @return view
	*/
	public function index($author)
	{
		// Grab author model
		$author = $this->model->where("username", $author)->first();
		// Validate model
		if (!$author) {
			// Not found
			return App::abort(404);
		};
		// Get posts
		$list = $author->posts()->where("publish_state", 1)->orderBy("created_at", "desc");
		// Validate search val
		if(!is_null($this->viewdata["searchVal"])){
			// Add LIKE filter
			$list = $list->where("title", "LIKE", "%".$this->viewdata["searchVal"]."%");
		}
		// Paginate posts
		$list = $list->paginate(15);
		// Get page data
		$page = $this->getPage("author", "page");
		$group = $this->getPage("author", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["list"] = $list;
		$this->viewdata["searchIn"] = Request::url();
		$this->viewdata["author"] = $author;
		// Load view
		return View::make("pages.posts.list", $this->viewdata);
	}

}
